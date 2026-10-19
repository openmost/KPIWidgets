<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets;

use Piwik\API\Request;
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\KPIWidgets\Services\MetricsService;
use Piwik\Plugins\KPIWidgets\Services\VueEntry;

class Controller extends \Piwik\Plugin\Controller
{
    private function isWidgetized()
    {
        // Check if we're in dashboard/widgetized context
        $request = \Piwik\Request::fromRequest();
        $module = $request->getStringParameter('module', '');
        $action = $request->getStringParameter('action', '');
        $widget = $request->getIntegerParameter('widget', 0);

        return $module === 'Widgetize' || $widget == 1 || $action === 'iframe';
    }

    public function goalConversions()
    {
        $context = MetricsService::getRequestContext();
        $idGoal = \Piwik\Request::fromRequest()->getIntegerParameter('idGoal', 0);

        $result = MetricsService::getGoalMetrics(
            $context['idSite'],
            $context['period'],
            $context['date'],
            $idGoal
        );

        $formatter = new Formatter();
        $rawValue = 0;
        if ($result && isset($result->nb_conversions)) {
            $rawValue = $result->nb_conversions;
        }
        $value = $formatter->getPrettyNumber($rawValue);

        $evolution = MetricsService::getEvolution(
            $context['idSite'],
            $context['period'],
            $context['date'],
            'nb_conversions',
            $idGoal
        );

        $goalName = $this->getGoalName($context['idSite'], $idGoal);
        $title = sprintf('%s - %s', $goalName, Piwik::translate('KPIWidgets_Conversions'));

        return $this->renderGoalWidget($title, $value, $evolution);
    }

    public function goalConversionRate()
    {
        $context = MetricsService::getRequestContext();
        $idGoal = \Piwik\Request::fromRequest()->getIntegerParameter('idGoal', 0);

        $result = MetricsService::getGoalMetrics(
            $context['idSite'],
            $context['period'],
            $context['date'],
            $idGoal
        );

        $value = '0%';
        if ($result && isset($result->conversion_rate)) {
            $value = $result->conversion_rate;
        }

        $evolution = MetricsService::getEvolution(
            $context['idSite'],
            $context['period'],
            $context['date'],
            'conversion_rate',
            $idGoal
        );

        $goalName = $this->getGoalName($context['idSite'], $idGoal);
        $title = sprintf('%s - %s', $goalName, Piwik::translate('KPIWidgets_ConversionRate'));

        return $this->renderGoalWidget($title, $value, $evolution);
    }

    public function goalRevenue()
    {
        $context = MetricsService::getRequestContext();
        $idGoal = \Piwik\Request::fromRequest()->getIntegerParameter('idGoal', 0);

        $result = MetricsService::getGoalMetrics(
            $context['idSite'],
            $context['period'],
            $context['date'],
            $idGoal
        );

        $formatter = new Formatter();
        $rawValue = 0;
        if ($result && isset($result->revenue)) {
            $rawValue = $result->revenue;
        }
        $value = $formatter->getPrettyMoney($rawValue, $context['idSite']);

        $evolution = MetricsService::getEvolution(
            $context['idSite'],
            $context['period'],
            $context['date'],
            'revenue',
            $idGoal
        );

        $goalName = $this->getGoalName($context['idSite'], $idGoal);
        $title = sprintf('%s - %s', $goalName, Piwik::translate('General_ColumnRevenue'));

        return $this->renderGoalWidget($title, $value, $evolution);
    }

    private function getGoalName($idSite, $idGoal)
    {
        try {
            $goals = Request::processRequest('Goals.getGoals', [
                'idSite' => $idSite,
                'filter_limit' => '-1'
            ], []);

            foreach ($goals as $goal) {
                if ((int)$goal['idgoal'] === (int)$idGoal) {
                    return $goal['name'];
                }
            }
        } catch (\Exception $e) {
            // Ignore
        }
        return 'Goal ' . $idGoal;
    }

    private function renderGoalWidget($title, $value, $evolution)
    {
        // On dashboard Matomo adds the card wrapper and title, on reporting page the component renders them
        return VueEntry::renderKPIWidget([
            'cardTitle' => $this->isWidgetized() ? '' : $title,
            'value' => $value,
            'evolution' => $evolution,
            'isLowerValueBetter' => false,
        ]);
    }
}
