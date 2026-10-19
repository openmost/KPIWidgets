<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAverageRevenuePerUser extends EcommerceEnhancedBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_arpu';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_AverageRevenuePerUser';
    }

    protected static function getWidgetOrder(): int
    {
        return 32;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }
}
