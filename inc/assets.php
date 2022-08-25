<?php

use Flynt\Utils\Asset;
use Flynt\ComponentManager;
use Flynt\Utils\ScriptLoader;

call_user_func(function () {
    $loader = new ScriptLoader();
    add_filter('script_loader_tag', [$loader, 'filterScriptLoaderTag'], 10, 2);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'Flynt/assets',
        Asset::requireUrl('assets/main.js')
    );
    wp_script_add_data('Flynt/assets', 'defer', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
    ];
    wp_localize_script('Flynt/assets', 'FlyntData', $data);

    wp_enqueue_style(
        'Flynt/assets',
        Asset::requireUrl('assets/main.css')
    );
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script(
        'Flynt/assets/admin',
        Asset::requireUrl('assets/admin.js')
    );
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntData', $data);

    wp_enqueue_style(
        'Flynt/assets/admin',
        Asset::requireUrl('assets/admin.css')
    );
});
