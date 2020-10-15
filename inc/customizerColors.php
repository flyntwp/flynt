<?php

/**
 * Add theme options to customizer
 */

namespace Flynt\CustomizerColors;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use WP_Customize_Color_Control;

function getConfig()
{
    $colorsByTheme = [
        'default' => [
            'accent-default' => [
                'label'       => 'Accent',
                'default'     => '#4045A1',
                'description' => ''
            ],
            'headline-default' => [
                'label'       => 'Headline',
                'default'     => '#212121',
                'description' => ''
            ],
            'text-default' => [
                'label'       => 'Text',
                'default'     => '#383838',
                'description' => ''
            ],
            'border-default' => [
                'label'       => 'Border',
                'default'     => '#8E8E8E',
                'description' => ''
            ],
            'background-default' => [
                'label'       => 'Background',
                'default'     => '#ffffff',
                'description' => ''
            ],
        ],
        'light' => [
            'accent-light' => [
                'label'       => 'Accent',
                'default'     => '#4045A1',
                'description' => ''
            ],
            'headline-light' => [
                'label'       => 'Headline',
                'default'     => '#212121',
                'description' => ''
            ],
            'text-light' => [
                'label'       => 'Text',
                'default'     => '#383838',
                'description' => ''
            ],
            'border-light' => [
                'label'       => 'Border',
                'default'     => '#8E8E8E',
                'description' => ''
            ],
            'background-light' => [
                'label'       => 'Background',
                'default'     => '#fafafa',
                'description' => ''
            ],
        ],
        'dark' => [
            'accent-dark' => [
                'label'       => 'Accent',
                'default'     => '#ffffff',
                'description' => '',
            ],
            'headline-dark' => [
                'label'       => 'Headline',
                'default'     => '#FBFBFB',
                'description' => '',
            ],
            'text-dark' => [
                'label'       => 'Text',
                'default'     => '#E9E9EC',
                'description' => '',
            ],
            'border-dark' => [
                'label'       => 'Border',
                'default'     => '#7E7E8E',
                'description' => '',
            ],
            'background-dark' => [
                'label'       => 'Background',
                'default'     => '#2B2C46',
                'description' => '',
            ],
        ],
        'hero' => [
            'accent-hero' => [
                'label'       => 'Accent',
                'default'     => '#ffffff',
                'description' => '',
            ],
            'headline-hero' => [
                'label'       => 'Headline',
                'default'     => '#FBFCFC',
                'description' => '',
            ],
            'text-hero' => [
                'label'       => 'Text',
                'default'     => '#D4DFE0',
                'description' => '',
            ],
            'border-hero' => [
                'label'       => 'Border',
                'default'     => '#9CB6B5',
                'description' => '',
            ],
            'background-hero' => [
                'label'       => 'Background',
                'default'     => '#28615E',
                'description' => '',
            ],
        ],
    ];
    $sectionsByTheme = [
        'theme_colors_default' => __('Default', 'flynt'),
        'theme_colors_light' => __('Theme Light', 'flynt'),
        'theme_colors_dark' => __('Theme Dark', 'flynt'),
        'theme_colors_hero' => __('Theme Hero', 'flynt'),
    ];

    return [
        'colors' => $colorsByTheme,
        'sections' => $sectionsByTheme,
    ];
}

add_action('acf/init', function () {
    $options = Options::getGlobal('CustomizerColors');
    if ($options['enabled']) {
        add_action('customize_register', function ($wp_customize) use ($colorsDefault, $colorsLight, $colorsDark, $colorsHero) {
            $config = getConfig();
            $wp_customize->add_panel(
                'theme_colors_panel',
                [
                    'title' => __('Colors', 'flynt'),
                    // 'description' => 'description', // Include html tags such as <p>.
                    'priority' => 160, // Mixed with top-level-section hierarchy.
                ]
            );
            foreach (($config['sections'] ?? []) as $key => $title) {
                $wp_customize->add_section(
                    $key,
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
                        'theme_colors_' . $colorName,
                        [
                            'default'   => $colorConfig['default'],
                            'transport' => 'postMessage',
                        ]
                    );
                    // Controls
                    $wp_customize->add_control(
                        new WP_Customize_Color_Control(
                            $wp_customize,
                            'theme_colors_' . $colorName,
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

        add_action('wp_head', function () {
            $config = getConfig();

            $alphaColorAmount = 0.4;
            $darkenColorAmount = -0.1; // -0.1 darken value approximately equals scss darken 5%
            ?>
            <style type="text/css">
                :root.html {
                    <?php foreach (($config['colors'] ?? []) as $theme => $colors) {
                        foreach ($colors as $colorName => $colorConfig) {
                            $colorValue = get_theme_mod("theme_colors_{$colorName}", $colorConfig['default']);
                            echo "--theme-color-{$colorName}: {$colorValue};";
                        }
                        $accentColorValue = get_theme_mod("theme_colors_accent-{$theme}", $colors["accent-{$theme}"]);
                        $rgbaValue = hex2rgba($accentColorValue, $alphaColorAmount);
                        $darkenedValue = colorBrightness($accentColorValue, $darkenColorAmount);
                        echo "--theme-color-accent-alpha-{$theme}: {$rgbaValue};";
                        echo "--theme-color-accent-hover-{$theme}: {$darkenedValue};";
                    } ?>
            </style>
            <?php
        });
    }
});

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


function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';

    // Return default if no color provided
    if (empty($color)) {
          return $default;
    }

    // Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    // Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif (strlen($color) == 3) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }

    // Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    // Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    // Return rgb(a) color string
    return $output;
}

function colorBrightness($hex, $percent)
{
    // Work out if hash given
    $hash = '';
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    // HEX TO RGB
    $rgb = [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
    // CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * (1 - $positivePercent)); // round($rgb[$i] * (1-$positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    // RBG to Hex
    $hex = '';
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash . $hex;
}
