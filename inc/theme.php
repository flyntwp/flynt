<?php

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    /**
     * Remove type attribute from link and script tags.
     */
    add_theme_support('html5', ['script', 'style']);
});

add_filter('big_image_size_threshold', '__return_false');
