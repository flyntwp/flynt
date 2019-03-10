<?php

namespace Flynt\Features\Acf;

class FlexibleContentToggle
{

    public static function init()
    {
        self::addFlexibleContentControls();
    }

    public static function addFlexibleContentControls()
    {
        if (is_admin()) {
            // adds buttons to collapse/expand components
            add_filter('acf/get_field_label', function ($label, $field) {
                if ($field['type'] === 'flexible_content') {
                    $label .= '<span class="flexible-content-controls">';
                    $label .= '<span class="flexible-content-control"><a class="acf-icon small -collapse collapse-all" title="collapse all"></a></span>';
                    $label .= '<span class="flexible-content-control"><span class="-collapsed"><a class="acf-icon small -collapse expand-all" title="expand all"></a></span></span>';
                    $label .= '</span>';
                }
                return $label;
            }, 10, 2);
        }
    }
}
