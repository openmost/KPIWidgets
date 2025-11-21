<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Services;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\DataTable\Filter\CalculateEvolutionFilter;
use Piwik\Period\Factory as PeriodFactory;
use Piwik\Site;

class MetricsService
{
    /** @var array In-memory cache for API results */
    private static array $cache = [];

    /** @var bool Whether to calculate evolution */
    private static bool $evolutionEnabled = true;

    /**
     * Enable or disable evolution calculation globally
     */
    public static function setEvolutionEnabled(bool $enabled): void
    {
        self::$evolutionEnabled = $enabled;
    }

    /**
     * Check if evolution is enabled
     */
    public static function isEvolutionEnabled(): bool
    {
        return self::$evolutionEnabled;
    }

    /**
     * Clear the cache (useful for testing)
     */
    public static function clearCache(): void
    {
        self::$cache = [];
    }

    /**
     * Get all metrics from API.get with caching
     */
    public static function getMetrics(int $idSite, string $period, string $date): ?object
    {
        $cacheKey = self::getCacheKey('API.get', $idSite, $period, $date);

        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        try {
            $result = Request::processRequest('API.get', [
                'idSite' => $idSite,
                'period' => $period,
                'date' => $date,
            ]);

            $result = self::normalizeResult($result);

            self::$cache[$cacheKey] = $result;
            return $result;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get goal-specific metrics with caching
     */
    public static function getGoalMetrics(int $idSite, string $period, string $date, int $idGoal): ?object
    {
        $cacheKey = self::getCacheKey('Goals.get', $idSite, $period, $date, $idGoal);

        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        try {
            $result = Request::processRequest('Goals.get', [
                'idSite' => $idSite,
                'period' => $period,
                'date' => $date,
                'idGoal' => $idGoal,
            ]);

            $result = self::normalizeResult($result);

            self::$cache[$cacheKey] = $result;
            return $result;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Normalize API result to object
     */
    private static function normalizeResult($result): ?object
    {
        if ($result instanceof DataTable) {
            $row = $result->getFirstRow();
            if ($row) {
                return (object) $row->getColumns();
            }
            return (object) [];
        }

        if (is_array($result)) {
            return (object) $result;
        }

        if (is_object($result)) {
            return $result;
        }

        return null;
    }

    /**
     * Get a specific metric value
     */
    public static function getMetricValue(int $idSite, string $period, string $date, string $metricKey)
    {
        $metrics = self::getMetrics($idSite, $period, $date);
        return self::getMetricFromResult($metrics, $metricKey);
    }

    /**
     * Calculate evolution for a metric
     */
    public static function getEvolution(
        int $idSite,
        string $period,
        string $date,
        string $metricKey,
        ?int $idGoal = null
    ): ?array {
        if (!self::$evolutionEnabled) {
            return null;
        }

        try {
            $previousDate = self::getPreviousPeriodDate($idSite, $period, $date);

            // Get current and previous values
            if ($idGoal !== null) {
                $currentResult = self::getGoalMetrics($idSite, $period, $date, $idGoal);
                $previousResult = self::getGoalMetrics($idSite, $period, $previousDate, $idGoal);
            } else {
                $currentResult = self::getMetrics($idSite, $period, $date);
                $previousResult = self::getMetrics($idSite, $period, $previousDate);
            }

            // Safely get metric values from result objects
            $currentValue = self::getMetricFromResult($currentResult, $metricKey);
            $previousValue = self::getMetricFromResult($previousResult, $metricKey);

            // Handle percentage values (e.g., "15.5%")
            $currentValue = self::parseNumericValue($currentValue);
            $previousValue = self::parseNumericValue($previousValue);

            // Calculate evolution
            $evolutionPercent = CalculateEvolutionFilter::calculate(
                $currentValue,
                $previousValue,
                1
            );

            // Determine trend
            $trend = 0;
            if ($currentValue > $previousValue) {
                $trend = 1;
            } elseif ($currentValue < $previousValue) {
                $trend = -1;
            }

            return [
                'percent' => $evolutionPercent,
                'previousValue' => $previousValue,
                'trend' => $trend,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Safely get a metric value from result object
     */
    private static function getMetricFromResult($result, string $metricKey)
    {
        if ($result === null) {
            return 0;
        }

        // Try direct property access
        if (isset($result->$metricKey)) {
            return $result->$metricKey;
        }

        // Try as array (in case object behaves like array)
        if (is_object($result)) {
            $array = (array) $result;
            if (isset($array[$metricKey])) {
                return $array[$metricKey];
            }
        }

        return 0;
    }

    /**
     * Debug: Get all available keys from result
     */
    public static function debugGetKeys($result): array
    {
        if ($result === null) {
            return [];
        }
        if (is_object($result)) {
            return array_keys((array) $result);
        }
        if (is_array($result)) {
            return array_keys($result);
        }
        return [];
    }

    /**
     * Parse numeric value from string (handles percentages and localized numbers)
     */
    private static function parseNumericValue($value): float
    {
        if (is_string($value)) {
            // Remove % sign
            $value = str_replace('%', '', $value);
            // Remove spaces
            $value = trim($value);
            // Handle French/European decimal separator (comma -> dot)
            $value = str_replace(',', '.', $value);
            // Remove thousand separators (spaces or dots used as thousand sep)
            $value = preg_replace('/(?<=\d)\s+(?=\d)/', '', $value);
        }
        return (float) $value;
    }

    /**
     * Get previous period date
     */
    public static function getPreviousPeriodDate(int $idSite, string $period, string $date): string
    {
        $timezone = 'UTC';
        try {
            $site = new Site($idSite);
            $timezone = $site->getTimezone();
        } catch (\Exception $e) {
            // Use default timezone
        }

        $currentPeriod = PeriodFactory::build($period, $date, $timezone);
        $startDate = $currentPeriod->getDateStart();

        return match ($period) {
            'day' => $startDate->subDay(1)->toString(),
            'week' => $startDate->subWeek(1)->toString(),
            'month' => $startDate->subMonth(1)->toString(),
            'year' => $startDate->subYear(1)->toString(),
            default => $startDate->subDay(1)->toString(),
        };
    }

    /**
     * Generate cache key
     */
    private static function getCacheKey(string $method, int $idSite, string $period, string $date, ?int $idGoal = null): string
    {
        $key = "{$method}_{$idSite}_{$period}_{$date}";
        if ($idGoal !== null) {
            $key .= "_{$idGoal}";
        }
        return $key;
    }

    /**
     * Get request parameters from current context
     */
    public static function getRequestContext(): array
    {
        return [
            'idSite' => Common::getRequestVar('idSite', 1, 'int'),
            'period' => Common::getRequestVar('period', 'day', 'string'),
            'date' => Common::getRequestVar('date', 'today', 'string'),
        ];
    }
}
