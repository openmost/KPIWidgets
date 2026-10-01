<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Plugin\Manager as PluginManager;

class KPIWidgetsAIAgentVisits extends Base
{
    protected static function getMetricKey(): string
    {
        return 'nb_visits_ai_agent';
    }

    protected static function getWidgetName(): string
    {
        return 'AIAgents_ColumnAIAgentVisits';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_TRAFFIC;
    }

    protected static function getWidgetOrder(): int
    {
        return 40;
    }

    protected static function isAvailable(): bool
    {
        return PluginManager::getInstance()->isPluginActivated('AIAgents');
    }
}
