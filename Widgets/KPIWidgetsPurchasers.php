<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsPurchasers extends EcommerceEnhancedBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_purchasers';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_Purchasers';
    }

    protected static function getWidgetOrder(): int
    {
        return 30;
    }
}
