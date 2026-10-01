<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsNewVisits extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_new';
    }

    protected static function getWidgetName(): string
    {
        return 'VisitFrequency_ColumnNewVisits';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 18;
    }
}
