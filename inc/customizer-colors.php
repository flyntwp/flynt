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
                <?php echo (get_theme_mod('theme_colors_headline') !== '') ? ' --color-headline: ' . get_theme_mod('theme_colors_headline') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_light_theme') !== '') ? '--color-background-light: ' . get_theme_mod('theme_colors_light_theme') . ';' : null ?>
                <?php echo (get_theme_mod('theme_colors_dark_theme') !== '') ? '--color-background-dark: ' . get_theme_mod('theme_colors_dark_theme') . ';' : null ?>
            }
            <?php if (get_theme_mod('theme_colors_accent')) : ?>
                .themeReset .iconList--checkCircle li::before,
                .iconList--checkCircle li::before {
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' stroke='%23<?php echo substr(get_theme_mod('theme_colors_accent'), 1); ?>' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-check-circle'%3E%3Cpath d='M22 11.08V12a10 10 0 1 1-5.93-9.14'/%3E%3Cpath d='M22 4L12 14.01l-3-3'/%3E%3C/svg%3E%0A");
                }
            <?php endif;?>
            <?php if (get_theme_mod('theme_colors_text')) : ?>
                .themeReset select,
                select {
                    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline fill='none' stroke='%23<?php echo substr(get_theme_mod('theme_colors_headline'), 1); ?>' stroke-width='5'  points='2,9 16,25 30,9 '/%3E%3C/svg%3E");
                }
            <?php endif;?>
        </style>
    <?php
});
