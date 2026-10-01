<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Common;

class KPIWidgetsVisitsFromAIAssistantsShare extends Base
{
    protected static function getMetricKey(): string
    {
        return 'Referrers_visitorsFromAIAssistants_percent';
    }

    protected static function getWidgetName(): string
    {
        return 'KPIWidgets_ShareOfVisitsFromAIAssistants';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ACQUISITION;
    }

    protected static function getWidgetOrder(): int
    {
        return 21;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }

    protected static function isAvailable(): bool
    {
        return defined(Common::class . '::REFERRER_TYPE_AI_ASSISTANT');
    }
}
