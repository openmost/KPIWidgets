<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsNetRevenue extends EcommerceEnhancedPremiumBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_net_revenue';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_NetRevenue';
    }

    protected static function getWidgetOrder(): int
    {
        return 41;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
