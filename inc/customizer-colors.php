<?php

/**
 * Add theme options to customizer
 */

add_action('customize_register', function ($wp_customize) {
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

    // Theme light color
    $wp_customize->add_setting(
        'theme_colors_theme_light',
        [
            'default'   => '#f2f6fe',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_theme_light',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Theme Light', 'flynt'),
        ]
    ));

    // Theme Dark color
    $wp_customize->add_setting(
        'theme_colors_theme_dark',
        [
            'default'   => '#091a41',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_theme_dark',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Theme Dark', 'flynt'),
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
        'theme_colors_headlines',
        [
            'default'   => '#0b1016',
            'transport' => 'refresh',
        ]
    );

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'theme_colors_headlines',
        [
            'section' => 'theme_colors',
            'label'   => esc_html__('Headlines', 'flynt'),
        ]
    ));
});

add_action('wp_head', function () {
    ?>
        <style type="text/css">
            :root.html {
                <?php echo (get_theme_mod('theme_colors_brand') !== '') ? '--color-brand: ' . get_theme_mod('theme_colors_brand') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_accent') !== '') ? '--color-accent: ' . get_theme_mod('theme_colors_accent') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_theme_light') !== '') ? '--color-background-light: ' . get_theme_mod('theme_colors_theme_light') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_theme_dark') !== '') ? '--color-background-dark: ' . get_theme_mod('theme_colors_theme_dark') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_text') !== '') ? ' --color-text: ' . get_theme_mod('theme_colors_text') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_headlines') !== '') ? ' --color-headline: ' . get_theme_mod('theme_colors_headlines') . ';' : null ?>
            }
        </style>
    <?php
});
