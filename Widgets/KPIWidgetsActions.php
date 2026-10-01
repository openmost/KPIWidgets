<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsActions extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_actions';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnNbActions';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 19;
    }
}
