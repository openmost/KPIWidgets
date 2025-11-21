<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUsers extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_users';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnNbUsers';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 12;
    }
}
