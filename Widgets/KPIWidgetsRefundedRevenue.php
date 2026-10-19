<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsRefundedRevenue extends EcommerceEnhancedPremiumBase
{
    protected static function getMetricKey(): string
    {
        return 'ee_refund_amount';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_RefundedRevenue';
    }

    protected static function getWidgetOrder(): int
    {
        return 40;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_MONEY;
    }

    protected static function isLowerValueBetter(): bool
    {
        return true;
    }
}
