<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsRevenue extends Base
{
    protected static function getMetricKey(): string
    {
        return 'revenue';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnRevenue';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_GOALS;
    }

    protected static function getWidgetOrder(): int
    {
        return 32;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
