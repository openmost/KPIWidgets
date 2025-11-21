<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsKeywords extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_keywords';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnKeyword';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 29;
    }
}
