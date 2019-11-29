<?php

use Flynt\Utils\Asset;
use Flynt\Utils\ScriptLoader;

call_user_func(function () {
    $loader = new ScriptLoader();
    add_filter('script_loader_tag', [$loader, 'filterScriptLoaderTag'], 10, 2);
});

add_action('wp_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.js',
        'type' => 'script',
        'inFooter' => false,
    ]);
    wp_script_add_data('Flynt/assets', 'defer', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets', 'FlyntData', $data);
    Asset::enqueue([
        'name' => 'Flynt/assets',
        'path' => 'assets/main.css',
        'type' => 'style'
    ]);
});

add_action('admin_enqueue_scripts', function () {
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.js',
        'type' => 'script',
        'inFooter' => false,
    ]);
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntData', $data);
    Asset::enqueue([
        'name' => 'Flynt/assets/admin',
        'path' => 'assets/admin.css',
        'type' => 'style'
    ]);
});
