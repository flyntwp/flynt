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
    wp_enqueue_script(
        'Flynt/assets',
        Asset::requireUrl('assets/main.js'),
        [],
        null
    );
    wp_script_add_data('Flynt/assets', 'defer', true);
    wp_script_add_data('Flynt/assets', 'module', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
    ];
    wp_localize_script('Flynt/assets', 'FlyntData', $data);

    wp_enqueue_style(
        'Flynt/assets',
        Asset::requireUrl('assets/main.scss'),
        [],
        null
    );

    if (!Asset::isHotModuleReplacement()) {
        wp_style_add_data('Flynt/assets', 'preload', true);
    }
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script(
        'Flynt/assets/admin',
        Asset::requireUrl('assets/admin.js'),
        [],
        null
    );
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    wp_script_add_data('Flynt/assets/admin', 'module', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntData', $data);

    wp_enqueue_style(
        'Flynt/assets/admin',
        Asset::requireUrl('assets/admin.scss'),
        [],
        null
    );
});
