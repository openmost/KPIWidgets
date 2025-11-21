<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUniqueVisitors extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_uniq_visitors';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_UniqueVisitors';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 11;
    }
}
