<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsDownloads extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_downloads';
    }

    protected static function getWidgetName(): string
    {
        return 'General_Downloads';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 24;
    }
}
