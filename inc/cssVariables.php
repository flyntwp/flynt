<?php

/**
 * Output CSS variables in head before the main stylesheet.
 */

namespace Flynt\CSSVariables;

use Flynt\Variables;
use Flynt\Utils\ColorHelpers;

add_action('wp_head', function () {
    $variables = getCssVariables();
    ?>
    <style type="text/css">
        :root.html {
            <?php foreach ($variables as $variable => $value) {
                echo "--{$variable}: {$value}; ";
            } ?>
        }
    </style>
    <?php
}, 5);

function getCssVariables()
{
    $fields = getFields();
    $variables = [];

    foreach ($fields as $field) {
        $variable = $field['name'];
        $value = get_theme_mod($field['name'], $field['default']);
        $unit = $field['unit'] ?? '';
        $variables[$variable] = $value . $unit;

        if (isset($field['hsl']) && $field['type'] === 'color') {
            $hslCssVariables = generateHslaCssVariables($field, $value);
            foreach ($hslCssVariables as $variable => $value) {
                $variables[$variable] = $value;
            }
        }
    }

    return $variables;
}

function getFields()
{
    $settings = Variables\getVariables();
    $fields = [];

    foreach ($settings as $setting) {
        if ($setting['type'] === 'panel') {
            foreach ($setting['sections'] ?? [] as $section) {
                $fields = array_merge($section['fields'] ?? [], $fields);
            }
        } else if ($setting['type'] === 'section') {
            $fields = array_merge($setting['fields'] ?? [], $fields);
        }
    }

    return $fields;
}

function generateHslaCssVariables($field, $value)
{
    $colorHsla = ColorHelpers::hexToHsla($value);
    return [
        "{$field['name']}-h" => $colorHsla[0],
        "{$field['name']}-s" => $colorHsla[1],
        "{$field['name']}-l" => $colorHsla[2],
    ];
}
