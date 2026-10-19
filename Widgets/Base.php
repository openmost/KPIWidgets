<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Metrics\Formatter;
use Piwik\Plugins\KPIWidgets\Services\MetricsService;
use Piwik\Plugins\KPIWidgets\Services\VueEntry;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

abstract class Base extends Widget
{
    // Subcategories
    public const SUBCATEGORY_TRAFFIC = 'KPIWidgets_Traffic';
    public const SUBCATEGORY_ACQUISITION = 'KPIWidgets_Acquisition';
    public const SUBCATEGORY_BEHAVIOR = 'KPIWidgets_Behavior';
    public const SUBCATEGORY_GOALS = 'KPIWidgets_Goals';
    public const SUBCATEGORY_ECOMMERCE = 'KPIWidgets_Ecommerce';

    // Format types
    public const FORMAT_NUMBER = 'number';
    public const FORMAT_PERCENT = 'percent';
    public const FORMAT_TIME = 'time';
    public const FORMAT_DURATION = 'duration';
    public const FORMAT_MONEY = 'money';
    public const FORMAT_RAW = 'raw';

    public const UNAVAILABLE_VALUE = '-';

    /**
     * @return string The metric key from API response
     */
    abstract protected static function getMetricKey(): string;

    /**
     * @return string The translation key for widget name
     */
    abstract protected static function getWidgetName(): string;

    /**
     * @return string The subcategory for this widget
     */
    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    /**
     * @return int Widget order
     */
    protected static function getWidgetOrder(): int
    {
        return 100;
    }

    /**
     * @return string API method returning a single row that holds the metric
     */
    protected static function getApiMethod(): string
    {
        return 'API.get';
    }

    /**
     * @return array Parameters added to idSite, period and date for the API method
     */
    protected static function getApiParameters(): array
    {
        return [];
    }

    /**
     * @return bool Whether a metric missing from the API result renders as unavailable instead of 0
     */
    protected static function isMissingMetricUnavailable(): bool
    {
        return false;
    }

    /**
     * @return string Format type
     */
    protected static function getFormat(): string
    {
        return self::FORMAT_NUMBER;
    }

    /**
     * @return bool Whether lower values are better (for evolution color)
     */
    protected static function isLowerValueBetter(): bool
    {
        return false;
    }

    /**
     * @return bool Whether the metric exists on this Matomo install (source plugin active, core version recent enough)
     */
    protected static function isAvailable(): bool
    {
        return true;
    }

    /**
     * @return bool Whether to show evolution
     */
    protected static function showEvolution(): bool
    {
        return true;
    }

    public static function configure(WidgetConfig $config): void
    {
        $config->setCategoryId('KPIWidgets_KPI');
        $config->setSubcategoryId(static::getSubcategory());
        $config->setName(static::getWidgetName());
        $config->setOrder(static::getWidgetOrder());
        $config->setIsWidgetizable();
        $config->setIsEnabled(static::isAvailable());
    }

    public function render(): string
    {
        $context = MetricsService::getRequestContext();
        $metricKey = static::getMetricKey();

        $result = MetricsService::getReportMetrics(
            static::getApiMethod(),
            $context['idSite'],
            $context['period'],
            $context['date'],
            static::getApiParameters()
        );
        $currentValue = MetricsService::findMetricValue($result, $metricKey);

        if ($currentValue === null && static::isMissingMetricUnavailable()) {
            return VueEntry::renderKPIWidget([
                'value' => self::UNAVAILABLE_VALUE,
                'evolution' => null,
                'isLowerValueBetter' => static::isLowerValueBetter(),
            ]);
        }

        $currentValue ??= 0;

        $evolution = null;
        if (static::showEvolution()) {
            $evolution = MetricsService::getReportEvolution(
                static::getApiMethod(),
                $context['idSite'],
                $context['period'],
                $context['date'],
                $metricKey,
                static::getApiParameters()
            );
        }

        // Format the value
        $formattedValue = $this->formatValue($currentValue, $context['idSite']);

        return VueEntry::renderKPIWidget([
            'value' => $formattedValue,
            'evolution' => $evolution,
            'isLowerValueBetter' => static::isLowerValueBetter(),
        ]);
    }

    protected function formatValue($value, int $idSite): string
    {
        $formatter = new Formatter();

        return match (static::getFormat()) {
            self::FORMAT_NUMBER => $formatter->getPrettyNumber($value),
            self::FORMAT_PERCENT => is_numeric($value) ? $formatter->getPrettyNumber($value, 1) . '%' : (string) $value,
            self::FORMAT_TIME => is_numeric($value) ? gmdate('i\m\i\n s\s', (int) $value) : (string) $value,
            self::FORMAT_DURATION => is_numeric($value) ? $formatter->getPrettyTimeFromSeconds($value, true) : (string) $value,
            self::FORMAT_MONEY => $formatter->getPrettyMoney($value, $idSite),
            default => (string) $value,
        };
    }
}
