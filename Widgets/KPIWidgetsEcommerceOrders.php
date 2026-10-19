<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsEcommerceOrders extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'nb_conversions';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_Orders';
    }

    protected static function getWidgetOrder(): int
    {
        return 10;
    }
}
