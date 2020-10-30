<?php

/**
 * Add theme options to customizer
 */

namespace Flynt\Customizer;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Flynt\Variables;
use Flynt\CSSVariables;

add_action('acf/init', function () {
    $options = Options::getGlobal('Customizer');

    if ($options['enabled']) {
        add_action('customize_register', function ($wp_customize) {
            $wp_customize->register_control_type('Flynt\Customizer\RangeControl');
            addSettings($wp_customize);
        });

        add_action('customize_controls_enqueue_scripts', function () {
            wp_enqueue_script(
                'Flynt/customizerControls',
                Asset::requireUrl('assets/customizerControls.js'),
                ['jquery']
            );
            wp_enqueue_style(
                'Flynt/customizerControls',
                Asset::requireUrl('assets/customizerControls.css')
            );
        });

        add_action('customize_preview_init', function () {
            wp_enqueue_script(
                'Flynt/customizerPreview',
                Asset::requireUrl('assets/customizerPreview.js'),
                ['jquery','customize-preview']
            );
            $fields = CSSVariables\getFields();
            wp_localize_script('Flynt/customizerPreview', 'FlyntCustomizerFields', $fields);
        });
    }
});

function addSettings($wp_customize)
{
    $settings = Variables\getVariables();

    foreach ($settings as $setting) {
        if ($setting['type'] === 'panel') {
            $wp_customize->add_panel(
                "flynt_panel_{$setting['name']}",
                [
                    'title' => $setting['label'],
                    'priority' => $setting['priority'] ?? 160,
                ]
            );

            foreach ($setting['sections'] ?? [] as $section) {
                addSection($wp_customize, $section, $setting['name']);
            }
        } else if ($setting['type'] === 'section') {
            addSection($wp_customize, $setting);
        }
    }
}

function addSection($wp_customize, $section, $panel = '')
{
    $panelKey = $panel ? "{$panel}_" : '';
    $sectionKey = "flynt_section_{$panelKey}{$section['name']}";
    $wp_customize->add_section(
        $sectionKey,
        [
            'title' => $section['label'],
            'priority' => $section['priority'] ?? 160,
            'panel' => $panel ? "flynt_panel_{$panel}" : '',
        ]
    );

    foreach ($section['fields'] ?? [] as $setting) {
        addSetting($wp_customize, $setting, $sectionKey);
    }
}

function addSetting($wp_customize, $setting, $sectionKey)
{
    $settingId = $setting['name'];
    unset($setting['name']);

    $wp_customize->add_setting(
        $settingId,
        [
            'default' => $setting['default'],
            'transport' => 'postMessage',
            'sanitize_callback' => getSanitizeCallback($setting['type']),
        ]
    );

    $controllClass = getControllCass($setting['type']);

    $wp_customize->add_control(
        new $controllClass(
            $wp_customize,
            $settingId,
            array_merge(
                $setting,
                [
                    'section' => $sectionKey,
                ]
            )
        )
    );
}

function getControllCass($type)
{
    $controls = [
        'color' => 'WP_Customize_Color_Control',
        'range' => 'Flynt\Customizer\RangeControl',
    ];

    return $controls[$type] ?? 'WP_Customize_Control';
}

function getSanitizeCallback($type)
{
    $sanitize = [
        'color' => 'sanitize_hex_color',
        'range' => 'Flynt\Customizer\sanitizeNumberRange',
    ];

    return $sanitize[$type] ?? '';
}

function sanitizeNumberRange($number, $setting)
{
    $number = absint($number);
    $options = $setting->manager->get_control($setting->id)->options;

    $min = $options['min'] ?? $number;
    $max = $options['max'] ?? $number;
    $step = $options['step'] ?? 1;

    if ($min <= $number && $number <= $max) {
        return $number;
    }

    return $setting->default;
}

Options::addGlobal('Customizer', [
    [
        'label' => __('Status', 'flynt'),
        'name' => 'enabled',
        'type' => 'true_false',
        'ui' => 1,
        'ui_on_text' => 'Enabled',
        'ui_off_text' => 'Disabled',
        'default_value' => true,
    ],
]);
