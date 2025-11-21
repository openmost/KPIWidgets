<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsAverageTimeGeneration extends Base
{
    protected static function getMetricKey(): string
    {
        return 'avg_time_generation';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnAverageGenerationTime';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 29;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_TIME;
    }

    protected static function isLowerValueBetter(): bool
    {
        return true;
    }
}
