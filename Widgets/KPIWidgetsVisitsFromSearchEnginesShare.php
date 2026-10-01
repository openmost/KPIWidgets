<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromSearchEnginesShare extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromSearchEngines_percent';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ShareOfVisitsFromSearchEngines';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 11;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
