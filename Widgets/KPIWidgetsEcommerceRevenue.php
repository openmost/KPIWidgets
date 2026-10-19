<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsEcommerceRevenue extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'revenue';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_EcommerceRevenue';
    }

    protected static function getWidgetOrder(): int
    {
        return 11;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
