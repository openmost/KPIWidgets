<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsWithAnOrder extends EcommerceBase
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_converted';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsWithAnOrder';
    }

    protected static function getWidgetOrder(): int
    {
        return 15;
    }
}
