<?php

/**
 * Removes `the_content` area (editor) from the Wordpress backend, since Flynt uses ACF.
 */

namespace Flynt\RemoveEditor;

add_action('init', function () {
    remove_post_type_support('page', 'editor');
    remove_post_type_support('post', 'editor');
});

/**
 * Removes Gutenberg default styles on front-end
 */
add_action('wp_print_styles', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
});
