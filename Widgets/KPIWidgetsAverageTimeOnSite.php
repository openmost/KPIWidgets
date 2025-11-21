<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAverageTimeOnSite extends Base
{
    protected static function getMetricKey(): string
    {
        return 'avg_time_on_site';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnAvgTimeOnSite';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 22;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_TIME;
    }
}
