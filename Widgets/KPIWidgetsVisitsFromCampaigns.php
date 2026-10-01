<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromCampaigns extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromCampaigns';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromCampaigns';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 60;
    }
}
