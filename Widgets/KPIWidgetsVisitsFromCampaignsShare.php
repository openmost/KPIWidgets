<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromCampaignsShare extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromCampaigns_percent';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ShareOfVisitsFromCampaigns';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 61;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
