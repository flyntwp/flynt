<?php

/**
 * Add theme options to customizer
 */

namespace Flynt\CustomizerColors;

use Flynt\Utils\Asset;
use Flynt\Utils\ColorHelpers;
use Flynt\Utils\Options;
use WP_Customize_Color_Control;

function getThemesConfig()
{
    $themes = [
        'default' => [
            'name' => __('Default', 'flynt'),
            'colors' => [
                'accent' => [
                    'label'       => __('Accent', 'flynt'),
                    'default'     => '#2b44df',
                    'description' => '',
                    'hsl'         => 1,
                ],
                'headline' => [
                    'label'       => __('Headline', 'flynt'),
                    'default'     => '#252525',
                    'description' => '',
                ],
                'text' => [
                    'label'       => __('Text', 'flynt'),
                    'default'     => '#353535',
                    'description' => '',
                ],
                'border' => [
                    'label'       => __('Border', 'flynt'),
                    'default'     => '#8791BA',
                    'description' => '',
                ],
                'background' => [
                    'label'       => __('Background', 'flynt'),
                    'default'     => '#ffffff',
                    'description' => '',
                ],
            ],
        ],
        'light' => [
            'name' => __('Theme Light', 'flynt'),
            'colors' => [
                'accent' => [
                    'label'       => __('Accent', 'flynt'),
                    'default'     => '#2b44df',
                    'description' => '',
                    'hsl'         => 1,
                ],
                'headline' => [
                    'label'       => __('Headline', 'flynt'),
                    'default'     => '#252525',
                    'description' => '',
                ],
                'text' => [
                    'label'       => __('Text', 'flynt'),
                    'default'     => '#353535',
                    'description' => '',
                ],
                'border' => [
                    'label'       => __('Border', 'flynt'),
                    'default'     => '#8791BA',
                    'description' => '',
                ],
                'background' => [
                    'label'       => __('Background', 'flynt'),
                    'default'     => '#F8F9FD',
                    'description' => '',
                ],
            ],
        ],
        'dark' => [
            'name' => __('Theme Dark', 'flynt'),
            'colors' => [
                'accent' => [
                    'label'       => __('Accent', 'flynt'),
                    'default'     => '#ffffff',
                    'description' => '',
                    'hsl'         => 1,
                ],
                'headline' => [
                    'label'       => __('Headline', 'flynt'),
                    'default'     => '#FBFBFB',
                    'description' => '',
                ],
                'text' => [
                    'label'       => __('Text', 'flynt'),
                    'default'     => '#E9E9EC',
                    'description' => '',
                ],
                'border' => [
                    'label'       => __('Border', 'flynt'),
                    'default'     => '#C3C4F7',
                    'description' => '',
                ],
                'background' => [
                    'label'       => __('Background', 'flynt'),
                    'default'     => '#10205A',
                    'description' => '',
                ],
            ],
        ],
        'hero' => [
            'name' => __('Theme Hero', 'flynt'),
            'colors' => [
                'accent' => [
                    'label'       => __('Accent', 'flynt'),
                    'default'     => '#ffffff',
                    'description' => '',
                    'hsl'         => 1,
                ],
                'headline' => [
                    'label'       => __('Headline', 'flynt'),
                    'default'     => '#FBFBFB',
                    'description' => '',
                ],
                'text' => [
                    'label'       => __('Text', 'flynt'),
                    'default'     => '#E9E9EC',
                    'description' => '',
                ],
                'border' => [
                    'label'       => __('Border', 'flynt'),
                    'default'     => '#CDE2FD',
                    'description' => '',
                ],
                'background' => [
                    'label'       => __('Background', 'flynt'),
                    'default'     => '#2B44DF',
                    'description' => '',
                ],
            ],
        ],
    ];

    return $themes;
}

add_action('acf/init', function () {
    $options = Options::getGlobal('CustomizerColors');
    if ($options['enabled']) {
        add_action('customize_register', function ($wp_customize) {
            $themes = getThemesConfig();

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
                        'title' => $theme['name'],
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
                        ]
                    );

                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            "theme_{$themeKey}_color_{$colorName}",
                            [
                                'section' => "theme_{$themeKey}_colors",
                                'label' => __($colorConfig['label']),
                                'description' => __($colorConfig['description']),
                            ]
                        )
                    );
                }
            }
        });

        add_action('customize_preview_init', function () {
            wp_enqueue_script(
                'customizer-colors',
                Asset::requireUrl('assets/customizer-colors.js'),
                ['jquery','customize-preview'],
            );
            $themes = getThemesConfig();
            $config = array_map(function ($theme) {
                return $theme['colors'];
            }, $themes);
            wp_localize_script('customizer-colors', 'FlyntCustomizerColorsData', $config);
        });
    }
});

add_action('wp_head', function () {
    $themes = getThemesConfig();
    ?>
    <style type="text/css">
        :root.html {
            <?php foreach ($themes as $themeKey => $theme) {
                foreach ($theme['colors'] as $colorName => $colorConfig) {
                    $colorValue = get_theme_mod("theme_{$themeKey}_color_{$colorName}", $colorConfig['default']);
                    $cssProperty = "--theme-{$themeKey}-color-{$colorName}";
                    echo "{$cssProperty}: {$colorValue};";

                    if ($colorConfig['hsl'] ?? false) {
                        $colorHsla = ColorHelpers::hexToHsla($colorValue);
                        echo "{$cssProperty}-h: {$colorHsla[0]};";
                        echo "{$cssProperty}-s: {$colorHsla[1]};";
                        echo "{$cssProperty}-l: {$colorHsla[2]};";
                    }
                }
            } ?>
        }
    </style>
    <?php
}, 5);

Options::addGlobal('CustomizerColors', [
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
