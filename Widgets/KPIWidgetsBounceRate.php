<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

class KPIWidgetsBounceRate extends Base
{
    protected static function getMetricKey(): string
    {
        return 'bounce_rate';
    }

    protected static function getWidgetName(): string
    {
        return 'General_ColumnBounceRate';
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_BEHAVIOR;
    }

    protected static function getWidgetOrder(): int
    {
        return 20;
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_RAW;
    }

    protected static function isLowerValueBetter(): bool
    {
        return true;
    }
}
