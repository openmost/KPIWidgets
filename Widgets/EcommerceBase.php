<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Plugin\Manager as PluginManager;
use Piwik\Request;
use Piwik\Site;

abstract class EcommerceBase extends Base
{
    public const ECOMMERCE_ORDER = 'ecommerceOrder';
    public const ECOMMERCE_ABANDONED_CART = 'ecommerceAbandonedCart';

    /**
     * @return string[] Plugins that must be activated for the widget to be listed
     */
    protected static function getRequiredPlugins(): array
    {
        return ['Goals', 'Ecommerce'];
    }

    protected static function getSubcategory(): string
    {
        return self::SUBCATEGORY_ECOMMERCE;
    }

    protected static function getApiMethod(): string
    {
        return 'Goals.get';
    }

    protected static function getApiParameters(): array
    {
        return ['idGoal' => self::ECOMMERCE_ORDER];
    }

    protected static function getFormat(): string
    {
        return self::FORMAT_NUMBER;
    }

    protected static function isMissingMetricUnavailable(): bool
    {
        return true;
    }

    protected static function isAvailable(): bool
    {
        return static::areRequiredPluginsActivated()
            && static::isEcommerceEnabledForSite(Request::fromRequest()->getIntegerParameter('idSite', 0));
    }

    public static function areRequiredPluginsActivated(): bool
    {
        $pluginManager = PluginManager::getInstance();

        foreach (static::getRequiredPlugins() as $plugin) {
            if (!$pluginManager->isPluginActivated($plugin)) {
                return false;
            }
        }

        return true;
    }

    public static function isEcommerceEnabledForSite(int $idSite): bool
    {
        if ($idSite <= 0) {
            return false;
        }

        try {
            return Site::isEcommerceEnabledFor($idSite);
        } catch (\Exception $e) {
            return false;
        }
    }
}
