<?php

/**
 * Add theme options to customizer
 */

namespace Flynt\Customizer;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use WP_Customize_Color_Control;
use Flynt\Variables;

add_action('acf/init', function () {
    $options = Options::getGlobal('Customizer');
    if ($options['enabled']) {
        add_action('customize_register', function ($wp_customize) {
            $wp_customize->register_control_type('Flynt\Customizer\RangeControl');

            addSizesSettings($wp_customize);
            addColorsSettings($wp_customize);
        });

        add_action('customize_controls_enqueue_scripts', function () {
            wp_enqueue_script(
                'Flynt/customizerControls',
                Asset::requireUrl('assets/customizerControls.js'),
                ['jquery','customize-preview']
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
            $themes = Variables\getColors();
            $config = array_map(function ($theme) {
                return $theme['colors'];
            }, $themes);
            wp_localize_script('Flynt/customizerPreview', 'FlyntCustomizerData', $config);
        });
    }
});

function addSizesSettings($wp_customize)
{
    $sizes = Variables\getSizes();

    $wp_customize->add_section(
        "sizes_section",
        [
            'title' => __('Sizes', 'flynt'),
            'priority' => 150,
        ]
    );

    foreach ($sizes as $sizeKey => $size) {
        $sizeKey = str_replace('-', '_', $sizeKey);

        $wp_customize->add_setting(
            "size_{$sizeKey}",
            [
                'default' => $size['default'],
                'transport' => 'postMessage',
                'sanitize_callback' => "Flynt\\Customizer\\sanitizeNumberRange",
            ]
        );

        $wp_customize->add_control(
            new RangeControl(
                $wp_customize,
                "size_{$sizeKey}",
                [
                    'section' => "sizes_section",
                    'label' => $size['label'],
                    'description' => $size['description'] ?? '',
                    'unit' => $size['unit'],
                    'options' => $size['options'],
                ]
            )
        );
    }
}

function addColorsSettings($wp_customize)
{
    $themes = Variables\getColors();

    $wp_customize->add_panel(
        'theme_colors_panel',
        [
            'title' => __('Colors', 'flynt'),
            'priority' => 160,
        ]
    );

    foreach ($themes as $key => $theme) {
        $wp_customize->add_section(
            "theme_{$key}_colors",
            [
                'title' => $theme['label'],
                'priority' => 20,
                'panel' => 'theme_colors_panel',
            ]
        );
    }

    foreach ($themes as $themeKey => $theme) {
        foreach ($theme['colors'] as $colorName => $colorConfig) {
            $wp_customize->add_setting(
                "theme_{$themeKey}_color_{$colorName}",
                [
                    'default' => $colorConfig['default'],
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'sanitize_hex_color',
                ]
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    "theme_{$themeKey}_color_{$colorName}",
                    [
                        'section' => "theme_{$themeKey}_colors",
                        'label' => $colorConfig['label'],
                        'description' => $colorConfig['description'] ?? '',
                    ]
                )
            );
        }
    }
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
