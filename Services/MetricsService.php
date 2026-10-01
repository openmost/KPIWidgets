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
use Piwik\Cache;
use Piwik\Common;
use Piwik\DataTable;
use Piwik\Date;
use Piwik\DataTable\Filter\CalculateEvolutionFilter;
use Piwik\Period\Factory as PeriodFactory;
use Piwik\Piwik;
use Piwik\Site;

class MetricsService
{
    private const CACHE_TTL_CURRENT_PERIOD = 300;
    private const CACHE_TTL_CLOSED_PERIOD = 3600;

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
        return self::fetch('API.get', [
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
        ]);
    }

    /**
     * Get goal-specific metrics with caching
     */
    public static function getGoalMetrics(int $idSite, string $period, string $date, int $idGoal): ?object
    {
        return self::fetch('Goals.get', [
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'idGoal' => $idGoal,
        ]);
    }

    /**
     * Each dashboard widget is its own HTTP request, so the in-memory layer only dedupes calls inside one
     * widget, the persistent layer is what spares the archive reads across all widgets of a dashboard.
     */
    private static function fetch(string $method, array $params): ?object
    {
        $segment = Request::getRawSegmentFromRequest();
        if (!empty($segment)) {
            $params['segment'] = $segment;
        }

        $cacheKey = 'KPIWidgets_' . md5($method . serialize($params));

        if (array_key_exists($cacheKey, self::$cache)) {
            return self::$cache[$cacheKey];
        }

        // A persistent cache hit bypasses Request::processRequest and its access check
        Piwik::checkUserHasViewAccess($params['idSite']);

        $persistentCache = Cache::getLazyCache();
        $columns = $persistentCache->fetch($cacheKey);

        if (!is_array($columns)) {
            try {
                $columns = self::normalizeResult(Request::processRequest($method, $params));
            } catch (\Exception $e) {
                return null;
            }

            if ($columns === null) {
                return null;
            }

            $persistentCache->save(
                $cacheKey,
                $columns,
                self::getCacheTtl($params['idSite'], $params['period'], $params['date'])
            );
        }

        return self::$cache[$cacheKey] = (object) $columns;
    }

    /**
     * Periods still running get a short TTL so KPIs stay close to live, closed periods only change on
     * archive invalidation (log import, reprocessing) so an hour of staleness is acceptable.
     */
    private static function getCacheTtl(int $idSite, string $period, string $date): int
    {
        try {
            $timezone = Site::getTimezoneFor($idSite);
            $periodEnd = PeriodFactory::build($period, $date, $timezone)->getDateEnd();

            return $periodEnd->isEarlier(Date::factory('today', $timezone))
                ? self::CACHE_TTL_CLOSED_PERIOD
                : self::CACHE_TTL_CURRENT_PERIOD;
        } catch (\Exception $e) {
            return self::CACHE_TTL_CURRENT_PERIOD;
        }
    }

    /**
     * Normalize API result to a plain array of columns
     */
    private static function normalizeResult($result): ?array
    {
        if ($result instanceof DataTable) {
            $row = $result->getFirstRow();
            return $row ? $row->getColumns() : [];
        }

        if (is_array($result)) {
            return $result;
        }

        if (is_object($result)) {
            return (array) $result;
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
