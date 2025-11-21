<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsPageViews extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_pageviews';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_PageViews';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 13;
    }
}
