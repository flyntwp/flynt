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
    'brand' => [
        'label'       => 'Hero Theme',
        'default'     => '#0d8eff',
        'description' => 'Changes color of hero theme background, pill element and button hover in dark background.',
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

            <?php if (get_theme_mod('theme_colors_accent')) : ?>
                .themeReset .iconList--checkCircle li::before,
                .iconList--checkCircle li::before {
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' stroke='%23<?php echo substr(get_theme_mod('theme_colors_accent'), 1); ?>' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-check-circle'%3E%3Cpath d='M22 11.08V12a10 10 0 1 1-5.93-9.14'/%3E%3Cpath d='M22 4L12 14.01l-3-3'/%3E%3C/svg%3E%0A");
                }
            <?php endif;?>
            <?php if (get_theme_mod('theme_colors_headline')) : ?>
                .themeReset select,
                select {
                    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline fill='none' stroke='%23<?php echo substr(get_theme_mod('theme_colors_headline'), 1); ?>' stroke-width='5'  points='2,9 16,25 30,9 '/%3E%3C/svg%3E");
                }
            <?php endif;?>
        </style>
    <?php }
});
