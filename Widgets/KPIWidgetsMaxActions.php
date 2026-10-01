<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsMaxActions extends Base
{
    protected static function getMetricKey(): string
    {
        return 'max_actions';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnMaxActions';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 23;
    }
}
