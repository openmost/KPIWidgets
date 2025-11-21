<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsActionsPerVisits extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_actions_per_visit';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnActionsPerVisit';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 21;
    }
}
