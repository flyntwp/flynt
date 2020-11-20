<?php

/**
 * Enqueue Google Fonts.
 */

namespace Flynt\GoogleFonts;

use Flynt\Variables;

add_action('wp_enqueue_scripts', function () {
    $url = getFontsUrl();

    if ($url) {
        wp_enqueue_style('Flynt/fonts', $url, [], null);
    }
}, 5);

add_filter('wp_resource_hints', function ($urls, $type) {
    if (wp_style_is('Flynt/fonts', 'queue') && $type === 'preconnect') {
        $urls[] = [
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        ];
    }

    return $urls;
}, 10, 2);

add_action('wp_head', function () {
    $url = getFontsUrl();

    if ($url) {
        echo "<link rel='preload' as='style' href='{$url}'>\n";
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
