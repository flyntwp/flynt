<?php

/**
 * Add theme options to customizer
 */

namespace Flynt\CustomizerColors;

use Flynt\Utils\Asset;
use Flynt\Utils\ColorHelpers;
use Flynt\Utils\Options;
use WP_Customize_Color_Control;

function getConfig()
{
    $colorsByTheme = [
        'default' => [
            'accent' => [
                'label'       => 'Accent',
                'default'     => '#2b44df',
                'description' => ''
            ],
            'headline' => [
                'label'       => 'Headline',
                'default'     => '#252525',
                'description' => ''
            ],
            'text' => [
                'label'       => 'Text',
                'default'     => '#353535',
                'description' => ''
            ],
            'border' => [
                'label'       => 'Border',
                'default'     => '#8791BA',
                'description' => ''
            ],
            'background' => [
                'label'       => 'Background',
                'default'     => '#ffffff',
                'description' => ''
            ],
        ],
        'light' => [
            'accent' => [
                'label'       => 'Accent',
                'default'     => '#2b44df',
                'description' => ''
            ],
            'headline' => [
                'label'       => 'Headline',
                'default'     => '#252525',
                'description' => ''
            ],
            'text' => [
                'label'       => 'Text',
                'default'     => '#353535',
                'description' => ''
            ],
            'border' => [
                'label'       => 'Border',
                'default'     => '#8791BA',
                'description' => ''
            ],
            'background' => [
                'label'       => 'Background',
                'default'     => '#F8F9FD',
                'description' => ''
            ],
        ],
        'dark' => [
            'accent' => [
                'label'       => 'Accent',
                'default'     => '#ffffff',
                'description' => '',
            ],
            'headline' => [
                'label'       => 'Headline',
                'default'     => '#FBFBFB',
                'description' => '',
            ],
            'text' => [
                'label'       => 'Text',
                'default'     => '#E9E9EC',
                'description' => '',
            ],
            'border' => [
                'label'       => 'Border',
                'default'     => '#C3C4F7',
                'description' => '',
            ],
            'background' => [
                'label'       => 'Background',
                'default'     => '#10205A',
                'description' => '',
            ],
        ],
        'hero' => [
            'accent' => [
                'label'       => 'Accent',
                'default'     => '#ffffff',
                'description' => '',
            ],
            'headline' => [
                'label'       => 'Headline',
                'default'     => '#FBFBFB',
                'description' => '',
            ],
            'text' => [
                'label'       => 'Text',
                'default'     => '#E9E9EC',
                'description' => '',
            ],
            'border' => [
                'label'       => 'Border',
                'default'     => '#CDE2FD',
                'description' => '',
            ],
            'background' => [
                'label'       => 'Background',
                'default'     => '#2B44DF',
                'description' => '',
            ],
        ],
    ];

    $sectionsByTheme = [
        'default' => __('Default', 'flynt'),
        'light' => __('Theme Light', 'flynt'),
        'dark' => __('Theme Dark', 'flynt'),
        'hero' => __('Theme Hero', 'flynt'),
    ];

    return [
        'colors' => $colorsByTheme,
        'sections' => $sectionsByTheme,
    ];
}

add_action('acf/init', function () {
    $options = Options::getGlobal('CustomizerColors');
    if ($options['enabled']) {
        add_action('customize_register', function ($wp_customize) {
            $config = getConfig();
            $wp_customize->add_panel(
                'theme_colors_panel',
                [
                    'title' => __('Colors', 'flynt'),
                    'priority' => 160,
                ]
            );
            foreach (($config['sections'] ?? []) as $key => $title) {
                $wp_customize->add_section(
                    "theme_colors_{$key}",
                    [
                        'title'      => $title,
                        'priority'   => 20,
                        'panel' => 'theme_colors_panel'
                    ]
                );
            }
            foreach (($config['colors'] ?? []) as $theme => $colors) {
                foreach ($colors as $colorName => $colorConfig) {
                    // Settings
                    $wp_customize->add_setting(
                        "theme_colors_{$colorName}_{$theme}",
                        [
                            'default'   => $colorConfig['default'],
                            'transport' => 'postMessage',
                        ]
                    );
                    // Controls
                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            "theme_colors_{$colorName}_{$theme}",
                            [
                                'section'     => 'theme_colors_' . $theme,
                                'label'       => __($colorConfig['label']),
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
                array('jquery','customize-preview'),
                '',
                true
            );
        });
    }
});

add_action('wp_head', function () {
    $config = getConfig();
    ?>
    <style type="text/css">
        :root.html {
            <?php foreach (($config['colors'] ?? []) as $theme => $colors) {
                foreach ($colors as $colorName => $colorConfig) {
                    $colorValue = get_theme_mod("theme_colors_{$colorName}_{$theme}", $colorConfig['default']);
                    echo "--theme-color-{$colorName}-{$theme}: {$colorValue};";
                }
                $accentColor = get_theme_mod("theme_colors_accent_{$theme}", $colors['accent']['default']);
                $accentColorHsla = ColorHelpers::hexToHsla($accentColor);
                echo "--theme-color-accent-h-{$theme}: {$accentColorHsla[0]};";
                echo "--theme-color-accent-s-{$theme}: {$accentColorHsla[1]};";
                echo "--theme-color-accent-l-{$theme}: {$accentColorHsla[2]};";
            } ?>
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
