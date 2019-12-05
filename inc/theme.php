<?php

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    /**
     * Remove type attributes from link and script tags..
     */
    global $wp_version;
    if ( version_compare( $wp_version, '5.3', '>=' ) ) {
        add_theme_support('html5', array('script', 'style'));
    }
});

add_filter('big_image_size_threshold', '__return_false');
