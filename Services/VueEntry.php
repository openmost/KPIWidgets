<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

declare(strict_types=1);

namespace Piwik\Plugins\KPIWidgets\Services;

use Piwik\Common;

class VueEntry
{
    /**
     * Render the mount point of the KPIWidgets.KPIWidget Vue component
     *
     * @param array $props camelCase prop name => value, JSON encoded into kebab-case attributes
     */
    public static function renderKPIWidget(array $props): string
    {
        $attributes = '';
        foreach ($props as $name => $value) {
            $attribute = strtolower((string) preg_replace('/[A-Z]/', '-$0', $name));
            $attributes .= sprintf(' %s="%s"', $attribute, Common::sanitizeInputValue(json_encode($value)));
        }

        return '<div vue-entry="KPIWidgets.KPIWidget"' . $attributes . '></div>';
    }
}
