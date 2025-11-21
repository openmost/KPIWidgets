<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsUniqueDownloads extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_uniq_downloads';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_UniqueDownloads';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 25;
    }
}
