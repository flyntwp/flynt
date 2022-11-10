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
        viteUrl('assets/main.js')
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
        viteUrl('assets/main.scss')
    );
    if (!isHot()) {
        wp_style_add_data('Flynt/assets', 'preload', true);
    }
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_script(
        'Flynt/assets/admin',
        viteUrl('assets/admin.js')
    );
    wp_script_add_data('Flynt/assets/admin', 'defer', true);
    wp_script_add_data('Flynt/assets/admin', 'module', true);
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntData', $data);

    wp_enqueue_style(
        'Flynt/assets/admin',
        viteUrl('assets/admin.scss')
    );
});

function viteUrl($asset)
{
    $hotFile = getViteHotFile();
    if (file_exists($hotFile)) {
        $baseUrl = trim(file_get_contents($hotFile));
        return trailingslashit($baseUrl) . $asset;
    } else {
        return Asset::requireUrl($asset);
    }
}

function getViteHotFile()
{
    return get_template_directory() . '/dist/hot';
}

function isHot()
{
    return file_exists(getViteHotFile());
}
