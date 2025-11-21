<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets;

use Piwik\API\Request;
use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Manager as PluginManager;
use Piwik\Widget\WidgetConfig;

class KPIWidgets extends \Piwik\Plugin
{
    public function registerEvents()
    {
        return array(
            'AssetManager.getStylesheetFiles' => 'getStylesheetFiles',
            'Widget.addWidgetConfigs' => 'addWidgetConfigs',
        );
    }

    public function getStylesheetFiles(&$files)
    {
        $files[] = "plugins/KPIWidgets/stylesheets/plugin.less";
    }

    public function addWidgetConfigs(&$configs)
    {
        if (!PluginManager::getInstance()->isPluginActivated('Goals')) {
            return;
        }

        $idSite = Common::getRequestVar('idSite', 0, 'int');
        if (empty($idSite)) {
            return;
        }

        try {
            $goals = Request::processRequest('Goals.getGoals', [
                'idSite' => $idSite,
                'filter_limit' => '-1'
            ], []);
        } catch (\Exception $e) {
            return;
        }

        foreach ($goals as $goal) {
            // Goal Conversions
            $config = new WidgetConfig();
            $config->setCategoryId('KPIWidgets_KPI');
            $config->setSubcategoryId('KPIWidgets_Goals');
            $config->setModule('KPIWidgets');
            $config->setAction('goalConversions');
            $config->setParameters(['idGoal' => $goal['idgoal']]);
            $config->setName(sprintf('%s - %s', $goal['name'], Piwik::translate('KPIWidgets_Conversions')));
            $config->setOrder(100 + ($goal['idgoal'] * 3));
            $config->setIsWidgetizable();
            $configs[] = $config;

            // Goal Conversion Rate
            $config = new WidgetConfig();
            $config->setCategoryId('KPIWidgets_KPI');
            $config->setSubcategoryId('KPIWidgets_Goals');
            $config->setModule('KPIWidgets');
            $config->setAction('goalConversionRate');
            $config->setParameters(['idGoal' => $goal['idgoal']]);
            $config->setName(sprintf('%s - %s', $goal['name'], Piwik::translate('KPIWidgets_ConversionRate')));
            $config->setOrder(101 + ($goal['idgoal'] * 3));
            $config->setIsWidgetizable();
            $configs[] = $config;

            // Goal Revenue
            $config = new WidgetConfig();
            $config->setCategoryId('KPIWidgets_KPI');
            $config->setSubcategoryId('KPIWidgets_Goals');
            $config->setModule('KPIWidgets');
            $config->setAction('goalRevenue');
            $config->setParameters(['idGoal' => $goal['idgoal']]);
            $config->setName(sprintf('%s - %s', $goal['name'], Piwik::translate('General_ColumnRevenue')));
            $config->setOrder(102 + ($goal['idgoal'] * 3));
            $config->setIsWidgetizable();
            $configs[] = $config;
        }
    }
}