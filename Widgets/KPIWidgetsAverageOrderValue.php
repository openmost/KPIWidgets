<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAverageOrderValue extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'avg_order_revenue';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_AverageOrderValue';
    }

    protected static function getWidgetOrder(): int
    {
        return 12;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
