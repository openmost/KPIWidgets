<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsProductsSold extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'items';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ProductsSold';
    }

    protected static function getWidgetOrder(): int
    {
        return 14;
    }
}
