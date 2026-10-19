<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAbandonedCartRevenue extends AbandonedCartBase
{
    protected static function getMetricKey(): string
    {
        return 'revenue';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_AbandonedCartRevenue';
    }

    protected static function getWidgetOrder(): int
    {
        return 21;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
