<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsEcommerceConversionRate extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'conversion_rate';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_EcommerceConversionRate';
    }

    protected static function getWidgetOrder(): int
    {
        return 13;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
