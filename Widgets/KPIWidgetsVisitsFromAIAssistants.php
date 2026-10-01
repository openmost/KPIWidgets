<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Common;

class KPIWidgetsVisitsFromAIAssistants extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromAIAssistants';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_VisitsFromAIAssistants';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 20;
    }

    protected static function isAvailable(): bool
    {
        return defined(Common::class . '::REFERRER_TYPE_AI_ASSISTANT');
    }
}
