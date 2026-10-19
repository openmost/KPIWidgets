<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAverageRevenuePerPayingUser extends EcommerceEnhancedBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_arppu';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_AverageRevenuePerPayingUser';
    }

    protected static function getWidgetOrder(): int
    {
        return 33;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
