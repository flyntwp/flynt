<?php

/**
 * Add theme options to customizer
 */

use Flynt\Utils\Asset;

add_action('customize_register', function ($wp_customize) {
    // TODO: Optimise this and get default colors.
    $wp_customize->add_section(
        'theme_colors',
        [
            'title'      => __('Colors', 'flynt'),
            'priority'   => 20,
        ]
    );

    // Accent color
    $wp_customize->add_setting(
        'theme_colors_accent',
        [
            'default'   => '#f96417',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_accent',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Accent', 'flynt'),
            'description' => 'Changes color of buttons, icons, links, blockquote border and table head border.'
        ]
    ));


    // Text color
    $wp_customize->add_setting(
        'theme_colors_text',
        [
            'default'   => '#414751',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_text',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Text', 'flynt'),
            'description' => 'Changes color of all running text.'
        ]
    ));

    // Headlines color
    $wp_customize->add_setting(
        'theme_colors_headline',
        [
            'default'   => '#0b1016',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_headline',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Headline', 'flynt'),
            'description' => 'Changes color of all headlines and form elements.'
        ]
    ));

    // Theme Hero color
    $wp_customize->add_setting(
        'theme_colors_brand',
        [
            'default'   => '#0d8eff',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_brand',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Hero Theme', 'flynt'),
            'description' => 'Changes color of hero theme background, pill element and button hover in dark background.'
        ]
    ));

    // Theme light color
    $wp_customize->add_setting(
        'theme_colors_light_theme',
        [
            'default'   => '#f2f6fe',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_light_theme',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Light Theme', 'flynt'),
            'description' => 'Changes light theme background color, table row and caption background.'
        ]
    ));

    // Theme Dark color
    $wp_customize->add_setting(
        'theme_colors_dark_theme',
        [
            'default'   => '#091a41',
            'transport' => 'postMessage',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_dark_theme',
        [
            'section'     => 'theme_colors',
            'label'       => esc_html__('Dark Theme', 'flynt'),
            'description' => 'Changes dark theme background color and button hover color.'
        ]
    ));
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
    ?>
        <style type="text/css">
            /* TODO: Remove this if there are no colors selected? */
            :root.html {
                <?php echo (get_theme_mod('theme_colors_accent') !== '') ? '--color-accent: ' . get_theme_mod('theme_colors_accent') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_text') !== '') ? ' --color-text: ' . get_theme_mod('theme_colors_text') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_headline') !== '') ? ' --color-headline: ' . get_theme_mod('theme_colors_headline') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_brand') !== '') ? '--color-brand: ' . get_theme_mod('theme_colors_brand') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_light_theme') !== '') ? '--color-background-light: ' . get_theme_mod('theme_colors_light_theme') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_dark_theme') !== '') ? '--color-background-dark: ' . get_theme_mod('theme_colors_dark_theme') . ';' : null ?>
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
    <?php
});
