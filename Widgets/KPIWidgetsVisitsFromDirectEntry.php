<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromDirectEntry extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromDirectEntry';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromDirectEntry';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 30;
    }
}
