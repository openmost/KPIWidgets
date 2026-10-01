<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromSocialNetworks extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromSocialNetworks';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromSocialNetworks';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 50;
    }
}
