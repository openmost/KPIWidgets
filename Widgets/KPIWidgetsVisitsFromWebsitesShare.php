<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromWebsitesShare extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromWebsites_percent';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ShareOfVisitsFromWebsites';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 41;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
