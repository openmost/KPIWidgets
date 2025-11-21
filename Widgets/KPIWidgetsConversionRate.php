<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsConversionRate extends Base
{
    protected static function getMetricKey(): string
    {
        return 'conversion_rate';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnConversionRate';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_GOALS;
    }

    protected static function getWidgetOrder(): int
    {
        return 31;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
