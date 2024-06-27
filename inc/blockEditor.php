<?php

/**
 * Block Editor related adjustments.
 */

namespace Flynt\BlockEditor;

/*
 * Disable Full Site Editing
 */
define('DISABLE_FSE', '__return_true');

/*
 * Disable Templates and Template Parts in Block Editor
 */
add_filter('block_editor_settings_all', function (array $settings): array {
    $settings['supportsTemplateMode'] = false;
    return $settings;
}, 10);

/*
 * Remove editor from Wordpress pages, since Flynt uses ACF.
 */
add_action('init', function (): void {
    remove_post_type_support('page', 'editor');
    remove_action('wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles');
});

/*
 * Remove Gutenberg block related styles on front-end, when a post has no blocks.
 */
add_action('wp_enqueue_scripts', function (): void {
    if (!has_blocks()) {
        wp_dequeue_style('core-block-supports');
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
});
