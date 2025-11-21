<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets\Categories;

use Piwik\Category\Category;

class KPICategory extends Category
{
    protected $id = 'KPIWidgets_KPI';
    protected $order = 2;
    protected $icon = 'icon-chart-bar';
}
