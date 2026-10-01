<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsVisitsFromSocialNetworksShare extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromSocialNetworks_percent';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ShareOfVisitsFromSocialNetworks';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 51;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }
}
