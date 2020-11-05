<?php

/**
 * Enqueue Google Fonts.
 */

namespace Flynt\GoogleFonts;

use Flynt\Variables;

add_action('wp_enqueue_scripts', function () {
    $url = getFontsUrl();

    if ($url) {
        wp_enqueue_style('Flynt/fonts', esc_url_raw($url));
    }
}, 5);

function getFontsUrl()
{
    $settings = getSettings();
    if ($settings) {
        $fonts = [];

        foreach ($settings as $family => $variants) {
            $fonts[] = "{$family}:{$variants}";
        }

        return add_query_arg([
            'family' => implode('|', $fonts),
            'display' => 'swap'
        ], 'https://fonts.googleapis.com/css');
    }

    return false;
}

function getSettings()
{
    $fields = getFields();
    $settings = [];

    foreach ($fields as $field) {
        $value = get_theme_mod($field['name'], $field['default']);
        $family = str_replace(' ', '+', $value['family']);
        $settings[$family][] = $value['variant'];
        if ($field['italic']) {
            $settings[$family][] = $value['variant'] . 'italic';
        }
    }

    return array_map(function ($setting) {
        return implode(',', array_values(array_unique($setting)));
    }, $settings);
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

    return array_values(array_filter($fields, function ($field) {
        return $field['type'] === 'flynt-typography';
    }));
}
