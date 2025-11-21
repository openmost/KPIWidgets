<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsSearches extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_searches';
    }

    protected static function getWidgetName(): string
    {
        return 'General_NbSearches';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 28;
    }
}
