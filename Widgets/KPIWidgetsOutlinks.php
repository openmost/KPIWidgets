<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsOutlinks extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_outlinks';
    }

    protected static function getWidgetName(): string
    {
        return 'General_Outlinks';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 26;
    }
}
