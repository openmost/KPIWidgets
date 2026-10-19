<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsProductsLeftInCarts extends AbandonedCartBase
{
    protected static function getMetricKey(): string
    {
        return 'items';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ProductsLeftInCarts';
    }

    protected static function getWidgetOrder(): int
    {
        return 22;
    }
}
