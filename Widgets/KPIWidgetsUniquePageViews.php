<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUniquePageViews extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_uniq_pageviews';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_UniquePageViews';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 14;
    }
}
