<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class KPIWidgetsConversions extends Widget
{

    /**
     * Configure the widget
     *
     * @param WidgetConfig $config
     */
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('KPI Widgets');

        $config->setName('General_ColumnVisitsWithConversions');
    }


    /**
     * Render the widget
     *
     * @return string
     */
    public function render()
    {
        $result = json_decode(\Piwik\API\Request::processRequest('API.get', ['format' => 'json']));

        return $this->renderTemplate('widget', ['value' => $result->nb_conversions]);
    }

}