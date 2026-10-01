<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Plugin\Manager as PluginManager;

class KPIWidgetsHumanVisits extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_human';
    }

    protected static function getWidgetName(): string
    {
        return 'AIAgents_ColumnHumanVisits';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 41;
    }

    protected static function isAvailable(): bool
    {
        return PluginManager::getInstance()->isPluginActivated('AIAgents');
    }
}
