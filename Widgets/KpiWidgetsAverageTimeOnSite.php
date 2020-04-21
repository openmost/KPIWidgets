<?php

namespace Piwik\Plugins\KpiWidgets\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;

class KpiWidgetsAverageTimeOnSite extends Widget
{

    /**
     * Configure the widget
     *
     * @param WidgetConfig $config
     */
    public static function configure(WidgetConfig $config)
    {
        $config->setCategoryId('KPI Widgets');

        $config->setName('General_ColumnAvgTimeOnSite');
    }


    /**
     * Render the widget
     *
     * @return string
     */
    public function render()
    {
        $result = \Piwik\API\Request::processRequest('API.get', ['format' => 'PHP']);

        $value = gmdate('i \m\i\n s\s', $result['avg_time_on_site']);

        return $this->renderTemplate('widget', ['value' => $value]);
    }

}