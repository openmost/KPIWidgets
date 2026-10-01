<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Plugin\Manager as PluginManager;

// Class name kept so dashboards that already pinned it keep working: avg_time_generation is no longer
// filled since Matomo 4, the widget now shows the PagePerformance page load time instead.
class KPIWidgetsAverageTimeGeneration extends Base
{
    protected static function getMetricKey(): string
    {
        return 'avg_page_load_time';
    }

    protected static function getWidgetName(): string
    {
        return 'PagePerformance_ColumnAveragePageLoadTime';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 29;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_DURATION;
    }

    protected static function isLowerValueBetter(): bool
    {
        return true;
    }

    protected static function isAvailable(): bool
    {
        return PluginManager::getInstance()->isPluginActivated('PagePerformance');
    }
}
