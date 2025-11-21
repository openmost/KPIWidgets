<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsReturningUsers extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_users_returning';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ReturningUsers';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 15;
    }
}
