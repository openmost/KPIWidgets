<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUniqueOutlinks extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_uniq_outlinks';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_UniqueOutlinks';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 27;
    }
}
