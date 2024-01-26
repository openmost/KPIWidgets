<?php

namespace Piwik\Plugins\KPIWidgets\Widgets;

use Piwik\Metrics\Formatter;
use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class KPIWidgetskeywords extends Widget
{

    /**
     * Configure the widget
     *
     * @param WidgetConfig $config
     */
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('KPI Widgets');

        $config->setName('General_ColumnKeyword');
    }


    /**
     * Render the widget
     *
     * @return string
     */
    public function render()
    {
        $result = json_decode(\Piwik\API\Request::processRequest('API.get', ['format' => 'json']));

        $formatter = new Formatter();
        $value = $formatter->getPrettyNumber($result->nb_keywords);

        return $this->renderTemplate('widget', ['value' => $value]);
    }

}