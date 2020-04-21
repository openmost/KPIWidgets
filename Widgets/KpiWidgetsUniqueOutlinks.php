<?php

namespace Piwik\Plugins\KpiWidgets\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class KpiWidgetsUniqueOutlinks extends Widget
{

    /**
     * Configure the widget
     *
     * @param WidgetConfig $config
     */
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('KPI Widgets');

        $config->setName('KpiWidgets_UniqueOutlinks');
    }


    /**
     * Render the widget
     *
     * @return string
     */
    public function render()
    {
        $result = \Piwik\API\Request::processRequest('API.get', ['format' => 'PHP']);

        return $this->renderTemplate('widget', ['value' => $result['nb_uniq_outlinks']]);
    }

}