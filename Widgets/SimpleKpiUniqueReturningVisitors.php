<?php

namespace Piwik\Plugins\SimpleKpi\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class SimpleKpiUniqueReturningVisitors extends Widget
{

    /**
     * Configure the widget
     *
     * @param WidgetConfig $config
     */
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('Simple KPI');

        $config->setName('SimpleKpi_UniqueReturningVisitors');
    }


    /**
     * Render the widget
     *
     * @return string
     */
    public function render()
    {
        $result = \Piwik\API\Request::processRequest('API.get', ['format' => 'PHP']);

        return $this->renderTemplate('widget', ['value' => $result['nb_uniq_visitors_returning']]);
    }

}