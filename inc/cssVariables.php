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
        $value = get_theme_mod($field['name'], $field['default']);
        $variable = [
            $field['name'] => $value,
        ];

        $variables = array_merge(
            apply_filters("Flynt/cssVariable?type={$field['type']}", $variable, $value, $field),
            $variables
        );
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

add_filter('Flynt/cssVariable?type=color', function ($variable, $value, $field) {
    if (isset($field['hsl'])) {
        $colorHsla = ColorHelpers::hexToHsla($value);
        $variable["{$field['name']}-h"] = $colorHsla[0];
        $variable["{$field['name']}-s"] = $colorHsla[1];
        $variable["{$field['name']}-l"] = $colorHsla[2];
    }

    return $variable;
}, 10, 3);

add_filter('Flynt/cssVariable?type=flynt-range', function ($variable, $value, $field) {
    $unit = $field['unit'] ?? '';
    $variable[$field['name']] = $value . $unit;

    return $variable;
}, 10, 3);

add_filter('Flynt/cssVariable?type=flynt-typography', function ($variable, $value, $field) {
    $fontFamily = array_filter([
        $value['family'] ?? '',
        $field['fallback'] ?? '',
        $value['category'] ?? '',
    ]);

    unset($variable[$field['name']]);
    $variable["{$field['name']}-family"] = implode(', ', $fontFamily);
    $variable["{$field['name']}-weight"] = $value['variant'];
    return $variable;
}, 10, 3);
