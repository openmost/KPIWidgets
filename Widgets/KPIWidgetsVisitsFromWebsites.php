<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromWebsites extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromWebsites';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromWebsites';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 40;
    }
}
