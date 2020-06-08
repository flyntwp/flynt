<?php

/**
 * Add theme options to customizer
 */

add_action('customize_register', function ($wp_customize) {
    // Add option to replace header logo
    $wp_customize->add_setting(
        'custom_header_logo',
        [
            'default' => '',
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options'
        ]
    );

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'custom_header_logo',
        [
            'label' => __('Replace Header Logo'),
            'description' => 'Upload file to replace header logo. Accepted file formats: jpg, jpeg, png, svg, gif.',
            'section' => 'title_tagline',
            'settings' => 'custom_header_logo',
            'priority'   => 10,
        ]
    ));
});
