<?php

/**
 * Add theme options to customizer
 */

use Flynt\Utils\Asset;

$colorsDefault = [
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
];

$colorsLight = [
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
];

$colorsDark = [
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
];

$colorsHero = [
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
];

add_action('customize_register', function ($wp_customize) use ($colorsDefault, $colorsLight, $colorsDark, $colorsHero) {
    $wp_customize->add_panel(
        'theme_colors_panel',
        [
            'title' => __('Colors', 'flynt'),
            'description' => 'description', // Include html tags such as <p>.
            'priority' => 160, // Mixed with top-level-section hierarchy.
         ]
    );

    $wp_customize->add_section(
        'theme_colors_default',
        [
            'title'      => __('Default', 'flynt'),
            'priority'   => 20,
            'panel' => 'theme_colors_panel'
        ]
    );

    $wp_customize->add_section(
        'theme_colors_light',
        [
            'title'      => __('Theme Light', 'flynt'),
            'priority'   => 20,
            'panel' => 'theme_colors_panel'
        ]
    );

    $wp_customize->add_section(
        'theme_colors_dark',
        [
            'title'      => __('Theme Dark', 'flynt'),
            'priority'   => 20,
            'panel' => 'theme_colors_panel'
        ]
    );

    $wp_customize->add_section(
        'theme_colors_hero',
        [
            'title'      => __('Theme Hero', 'flynt'),
            'priority'   => 20,
            'panel' => 'theme_colors_panel'
        ]
    );

    foreach ($colorsDefault as $name => $color) {
        // Settings
        $wp_customize->add_setting(
            'theme_colors_' . $name,
            [
                'default'   => $color['default'],
                'transport' => 'postMessage',
            ]
        );

        // Controls
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'theme_colors_' . $name,
                [
                    'section'     => 'theme_colors_default',
                    'label'       => __($color['label']),
                    'description' => __($color['description']),
                ]
            )
        );
    }

    foreach ($colorsLight as $name => $color) {
        // Settings
        $wp_customize->add_setting(
            'theme_colors_' . $name,
            [
                'default'   => $color['default'],
                'transport' => 'postMessage',
            ]
        );

        // Controls
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'theme_colors_' . $name,
                [
                    'section'     => 'theme_colors_light',
                    'label'       => __($color['label']),
                    'description' => __($color['description']),
                ]
            )
        );
    }

    foreach ($colorsDark as $name => $color) {
        // Settings
        $wp_customize->add_setting(
            'theme_colors_' . $name,
            [
                'default'   => $color['default'],
                'transport' => 'postMessage',
            ]
        );

        // Controls
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'theme_colors_' . $name,
                [
                    'section'     => 'theme_colors_dark',
                    'label'       => __($color['label']),
                    'description' => __($color['description']),
                ]
            )
        );
    }

    foreach ($colorsHero as $name => $color) {
        // Settings
        $wp_customize->add_setting(
            'theme_colors_' . $name,
            [
                'default'   => $color['default'],
                'transport' => 'postMessage',
            ]
        );

        // Controls
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'theme_colors_' . $name,
                [
                    'section'     => 'theme_colors_hero',
                    'label'       => __($color['label']),
                    'description' => __($color['description']),
                ]
            )
        );
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

add_action('wp_head', function () use ($colorsDefault, $colorsLight, $colorsDark, $colorsHero) {
    $hasChangedDefault = array_filter($colorsDefault, function ($color, $name) {
        $value = get_theme_mod('theme_colors_' . $name, $color['default']);
        return $value !== $color['default'];
    }, ARRAY_FILTER_USE_BOTH);

    $hasChangedLight = array_filter($colorsLight, function ($color, $name) {
        $value = get_theme_mod('theme_colors_' . $name, $color['default']);
        return $value !== $color['default'];
    }, ARRAY_FILTER_USE_BOTH);

    $hasChangedDark = array_filter($colorsDark, function ($color, $name) {
        $value = get_theme_mod('theme_colors_' . $name, $color['default']);
        return $value !== $color['default'];
    }, ARRAY_FILTER_USE_BOTH);

    $hasChangedHero = array_filter($colorsHero, function ($color, $name) {
        $value = get_theme_mod('theme_colors_' . $name, $color['default']);
        return $value !== $color['default'];
    }, ARRAY_FILTER_USE_BOTH);

    $alphaColorAmount = 0.4;
    $darkenColorAmount = -0.1; // -0.1 darken value approximately equals scss darken 5%

    if ($hasChangedDefault or $hasChangedLight or $hasChangedDark or $hasChangedHero) { ?>
        <style type="text/css">
            :root.html {
               <?php if ($hasChangedDefault) {
                    foreach ($colorsDefault as $name => $color) {
                        echo (get_theme_mod('theme_colors_' . $name)) ? '--theme-color-' . $name . ': ' . get_theme_mod('theme_colors_' . $name) . ';' : null;
                    };
                    echo (get_theme_mod('theme_colors_accent-default')) ? '--theme-color-accent-alpha-default: ' . hex2rgba(get_theme_mod('theme_colors_accent-default'), $alphaColorAmount) . ';' : null;
                    echo (get_theme_mod('theme_colors_accent-default')) ? '--theme-color-accent-hover-default: ' . colorBrightness(get_theme_mod('theme_colors_accent-default'), $darkenColorAmount) . ';' : null;
               } ?>
               <?php if ($hasChangedLight) {
                    foreach ($colorsLight as $name => $color) {
                        echo (get_theme_mod('theme_colors_' . $name)) ? '--theme-color-' . $name . ': ' . get_theme_mod('theme_colors_' . $name) . ';' : null;
                    };
                    echo (get_theme_mod('theme_colors_accent-light')) ? '--theme-color-accent-alpha-light: ' . hex2rgba(get_theme_mod('theme_colors_accent-light'), $alphaColorAmount) . ';' : null;
                    echo (get_theme_mod('theme_colors_accent-light')) ? '--theme-color-accent-hover-light: ' . colorBrightness(get_theme_mod('theme_colors_accent-light'), $darkenColorAmount) . ';' : null;
               } ?>
                <?php if ($hasChangedDark) {
                    foreach ($colorsDark as $name => $color) {
                        echo (get_theme_mod('theme_colors_' . $name)) ? '--theme-color-' . $name . ': ' . get_theme_mod('theme_colors_' . $name) . ';' : null;
                    };
                    echo (get_theme_mod('theme_colors_accent-dark')) ? '--theme-color-accent-alpha-dark: ' . hex2rgba(get_theme_mod('theme_colors_accent-dark'), $alphaColorAmount) . ';' : null;
                    echo (get_theme_mod('theme_colors_accent-dark')) ? '--theme-color-accent-hover-dark: ' . colorBrightness(get_theme_mod('theme_colors_accent-dark'), $darkenColorAmount) . ';' : null;
                } ?>
                <?php if ($hasChangedHero) {
                    foreach ($colorsHero as $name => $color) {
                        echo (get_theme_mod('theme_colors_' . $name)) ? '--theme-color-' . $name . ': ' . get_theme_mod('theme_colors_' . $name) . ';' : null;
                    };
                    echo (get_theme_mod('theme_colors_accent-hero')) ? '--theme-color-accent-alpha-hero: ' . hex2rgba(get_theme_mod('theme_colors_accent-hero'), $alphaColorAmount) . ';' : null;
                    echo (get_theme_mod('theme_colors_accent-hero')) ? '--theme-color-accent-hover-hero: ' . colorBrightness(get_theme_mod('theme_colors_accent-hero'), $darkenColorAmount) . ';' : null;
                } ?>
            }
        </style>
    <?php }
});
