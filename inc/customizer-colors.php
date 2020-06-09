<?php

/**
 * Add theme options to customizer
 */

add_action('customize_register', function ($wp_customize) {
    // TODO: Optimise this and get default colors.
    $wp_customize->add_section(
        'theme_colors',
        [
            'title'      => __('Colors', 'flynt'),
            'priority'   => 20,
        ]
    );

    // Brand color
    $wp_customize->add_setting(
        'theme_colors_brand',
        [
            'default'   => '#0d8eff',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_brand',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Brand', 'flynt'),
        ]
    ));

    // Accent color
    $wp_customize->add_setting(
        'theme_colors_accent',
        [
            'default'   => '#f96417',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_accent',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Accent', 'flynt'),
        ]
    ));


    // Text color
    $wp_customize->add_setting(
        'theme_colors_text',
        [
            'default'   => '#414751',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_text',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Text', 'flynt'),
        ]
    ));

    // Headlines color
    $wp_customize->add_setting(
        'theme_colors_headline',
        [
            'default'   => '#0b1016',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_headline',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Headline', 'flynt'),
        ]
    ));

    // Theme light color
    $wp_customize->add_setting(
        'theme_colors_light_theme',
        [
            'default'   => '#f2f6fe',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_light_theme',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Light Theme Background', 'flynt'),
        ]
    ));

    // Theme Dark color
    $wp_customize->add_setting(
        'theme_colors_dark_theme',
        [
            'default'   => '#091a41',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_dark_theme',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Dark Theme Background', 'flynt'),
        ]
    ));
});

add_action('wp_head', function () {
    ?>
        <style type="text/css">
            /* TODO: Remove this if there are no colors selected? */
            :root.html {
                <?php echo (get_theme_mod('theme_colors_brand') !== '') ? '--color-brand: ' . get_theme_mod('theme_colors_brand') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_accent') !== '') ? '--color-accent: ' . get_theme_mod('theme_colors_accent') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_text') !== '') ? ' --color-text: ' . get_theme_mod('theme_colors_text') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_headline') !== '') ? ' --color-headline: ' . get_theme_mod('theme_colors_headlines') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_light_theme') !== '') ? '--color-background-light: ' . get_theme_mod('theme_colors_theme_light') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_dark_theme') !== '') ? '--color-background-dark: ' . get_theme_mod('theme_colors_theme_dark') . ';' : null ?>
            }
        </style>
    <?php
});
