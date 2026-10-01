<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsConverted extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_converted';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnVisitsWithConversions';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_GOALS;
    }

    protected static function getWidgetOrder(): int
    {
        return 33;
    }
}
