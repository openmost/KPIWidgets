<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromSearchEngines extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromSearchEngines';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromSearchEngines';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 10;
    }
}
