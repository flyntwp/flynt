<?php

/**
 * Add theme options to customizer
 */

use Flynt\Utils\Asset;

$colors = [
    'accent' => [
        'label'       => 'Accent',
        'default'     => '#f96417',
        'description' => 'Changes color of buttons, icons, links, blockquote border and table head border.',
    ],
    'brand' => [
        'label'       => 'Brand',
        'default'     => '#0d8eff',
        'description' => 'Changes color of pill element and button hover in dark background.',
    ],
    'text' => [
        'label'       => 'Text',
        'default'     => '#414751',
        'description' => 'Changes color of all running text.',
    ],
    'headline' => [
        'label'       => 'Headline',
        'default'     => '#0b1016',
        'description' => 'Changes color of all headlines and form elements.',
    ],

    'border' => [
        'label'       => 'Border',
        'default'     => '#b7b7b7',
        'description' => 'Changes color of borders and separators.',
    ],
    'background' => [
        'label'       => 'Background',
        'default'     => '#ffffff',
        'description' => 'Changes white background color and all white elements.',
    ],
    'error' => [
        'label'       => 'Error',
        'default'     => '#ef3f45',
        'description' => 'Changes color of error messages.',
    ],
    'background-light' => [
        'label'       => 'Light Theme',
        'default'     => '#f2f6fe',
        'description' => 'Changes light theme background color, table row and caption background.',
    ],
    'background-dark' => [
        'label'       => 'Dark Theme',
        'default'     => '#091a41',
        'description' => 'Changes dark theme background color and button hover color.',
    ],
    'background-hero' => [
        'label'       => 'Hero Theme',
        'default'     => '#0d8eff',
        'description' => 'Changes color of hero theme background',
    ],
];

add_action('customize_register', function ($wp_customize) use ($colors) {
    $wp_customize->add_section(
        'theme_colors',
        [
            'title'      => __('Colors', 'flynt'),
            'priority'   => 20,
        ]
    );

    foreach ($colors as $name => $color) {
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
                    'section'     => 'theme_colors',
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

add_action('wp_head', function () use ($colors) {
    $hasChanged = array_filter($colors, function ($color, $name) {
        $value = get_theme_mod('theme_colors_' . $name, $color['default']);
        return $value !== $color['default'];
    }, ARRAY_FILTER_USE_BOTH);

    if ($hasChanged) { ?>
        <style type="text/css">
            :root.html {
                <?php foreach ($colors as $name => $color) {
                    echo (get_theme_mod('theme_colors_' . $name)) ? '--color-' . $name . ': ' . get_theme_mod('theme_colors_' . $name) . ';' : null;
                } ?>
            }
        </style>
    <?php }
});
