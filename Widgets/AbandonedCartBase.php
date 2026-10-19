<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Widgets;

abstract class AbandonedCartBase extends EcommerceBase
{
    protected static function getApiParameters(): array
    {
        return ['idGoal' => self::ECOMMERCE_ABANDONED_CART];
    }

    // A cart left behind is a sale not made, so fewer abandoned carts, revenue and products read as progress
    protected static function isLowerValueBetter(): bool
    {
        return true;
    }
}
