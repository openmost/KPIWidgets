<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUniqueReturningVisitors extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_uniq_visitors_returning';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_UniqueReturningVisitors';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 17;
    }
}
