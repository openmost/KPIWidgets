<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisits extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnNbVisits';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 10;
    }
}
