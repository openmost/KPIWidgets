<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Widgets;

/**
 * EcommerceEnhanced is optional: it is only reached through its HTTP API by name, never through its classes, so
 * KPIWidgets keeps working when its folder is missing.
 */
abstract class EcommerceEnhancedBase extends EcommerceBase
{
    protected static function getRequiredPlugins(): array
    {
        return array_merge(parent::getRequiredPlugins(), ['EcommerceEnhanced']);
    }

    protected static function getApiMethod(): string
    {
        return 'EcommerceEnhanced.getBuyerKpis';
    }

    protected static function getApiParameters(): array
    {
        return [];
    }
}
