<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsReturningVisitors extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_returning';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ReturningVisitor';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 16;
    }
}
