<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\KPIWidgets\Categories;

use Piwik\Category\Subcategory;

class TrafficSubcategory extends Subcategory
{
    protected $categoryId = 'KPIWidgets_KPI';
    protected $id = 'KPIWidgets_Traffic';
    protected $order = 1;
}
