<?php

/**
 * Removes editor from Wordpress pages, since Flynt uses ACF.
 */

namespace Flynt\RemoveEditor;

add_action('init', function () {
    remove_post_type_support('page', 'editor');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles');
});
