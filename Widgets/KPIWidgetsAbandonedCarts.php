<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAbandonedCarts extends AbandonedCartBase
{
    protected static function getMetricKey(): string
    {
        return 'nb_conversions';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_AbandonedCarts';
    }

    protected static function getWidgetOrder(): int
    {
        return 20;
    }
}
