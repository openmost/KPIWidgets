<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsFirstTimePurchasers extends EcommerceEnhancedBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_first_time_purchasers';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_FirstTimePurchasers';
    }

    protected static function getWidgetOrder(): int
    {
        return 31;
    }
}
