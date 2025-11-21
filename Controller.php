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
use Piwik\Metrics\Formatter;
use Piwik\Piwik;
use Piwik\Plugins\KPIWidgets\Services\MetricsService;

class Controller extends \Piwik\Plugin\Controller
{
    private function isWidgetized()
    {
        // Check if we're in dashboard/widgetized context
        $module = Common::getRequestVar('module', '', 'string');
        $action = Common::getRequestVar('action', '', 'string');
        $widget = Common::getRequestVar('widget', 0, 'int');

        return $module === 'Widgetize' || $widget == 1 || $action === 'iframe';
    }

    public function goalConversions()
    {
        $context = MetricsService::getRequestContext();
        $idGoal = Common::getRequestVar('idGoal', 0, 'int');

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
        $idGoal = Common::getRequestVar('idGoal', 0, 'int');

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
        $idGoal = Common::getRequestVar('idGoal', 0, 'int');

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
        // Use different template based on context
        // On dashboard: use simple widget template (Matomo adds the card wrapper)
        // On reporting page: use goalWidget template with card wrapper
        $template = $this->isWidgetized() ? 'widget' : 'goalWidget';

        return $this->renderTemplate($template, [
            'title' => $title,
            'value' => $value,
            'evolution' => $evolution,
            'isLowerValueBetter' => false,
        ]);
    }
}
