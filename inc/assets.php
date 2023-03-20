<?php

use Flynt\Utils\Asset;
use Flynt\ComponentManager;
use Flynt\Utils\ScriptAndStyleLoader;

call_user_func(function () {
    $loader = new ScriptAndStyleLoader();
    add_filter('script_loader_tag', [$loader, 'filterScriptLoaderTag'], 10, 3);
    add_filter('style_loader_tag', [$loader, 'filterStyleLoaderTag'], 10, 3);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('Flynt/assets/main', Asset::requireUrl('assets/main.js'), [], null);
    wp_script_add_data('Flynt/assets/main', 'defer', true);
    wp_script_add_data('Flynt/assets/main', 'module', true);

    wp_localize_script('Flynt/assets/main', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/main', Asset::requireUrl('assets/main.scss'), [], null);
    wp_enqueue_style('Flynt/assets/print', Asset::requireUrl('assets/print.scss'), [], null, 'print');

    if (!Asset::isHotModuleReplacement()) {
        wp_style_add_data('Flynt/assets/main', 'preload', true);
    }

    // Remove Gutenberg block related styles on front-end, when a post has no blocks.
    if (!has_blocks()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script('Flynt/assets/admin', Asset::requireUrl('assets/admin.js'), [], null);
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    wp_script_add_data('Flynt/assets/admin', 'module', true);

    wp_localize_script('Flynt/assets/admin', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/admin', Asset::requireUrl('assets/admin.scss'), [], null);
});
