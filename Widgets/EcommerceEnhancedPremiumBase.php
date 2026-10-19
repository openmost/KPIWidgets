<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Widgets;

abstract class EcommerceEnhancedPremiumBase extends EcommerceEnhancedBase
{
    protected static function getRequiredPlugins(): array
    {
        return array_merge(parent::getRequiredPlugins(), ['EcommerceEnhancedPremium']);
    }

    protected static function getApiMethod(): string
    {
        return 'EcommerceEnhancedPremium.getRefunds';
    }
}
