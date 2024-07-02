<?php

namespace Flynt\Assets;

use Flynt\Utils\Asset;
use Flynt\ComponentManager;
use Flynt\Utils\ScriptAndStyleLoader;

call_user_func(function (): void {
    $loader = new ScriptAndStyleLoader();
    add_filter('script_loader_tag', [$loader, 'filterScriptLoaderTag'], 10, 3);
});

add_action('wp_enqueue_scripts', function (): void {
    wp_enqueue_script('Flynt/assets/main', Asset::requireUrl('assets/main.js'), [], null);
    wp_script_add_data('Flynt/assets/main', 'module', true);

    wp_localize_script('Flynt/assets/main', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/main', Asset::requireUrl('assets/main.scss'), [], null);
    wp_enqueue_style('Flynt/assets/print', Asset::requireUrl('assets/print.scss'), [], null, 'print');
});

add_action('admin_enqueue_scripts', function (): void {
    wp_enqueue_script('Flynt/assets/admin', Asset::requireUrl('assets/admin.js'), [], null);
    wp_script_add_data('Flynt/assets/admin', 'module', true);

    wp_localize_script('Flynt/assets/admin', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);

    wp_enqueue_style('Flynt/assets/admin', Asset::requireUrl('assets/admin.scss'), [], null);
});

// Add component stylesheets to the head.
add_filter('timber/compile/result', function ($output) {
    if (strpos($output, '<!DOCTYPE html>') === false) {
        return $output;
    }

    $componentManager = ComponentManager::getInstance();
    $components = $componentManager->getAll();
    foreach ($components as $componentName => $componentPath) {
        $handle = "Flynt/assets/components/{$componentName}";
        if (wp_style_is($handle, 'registered') && !wp_style_is($handle, 'enqueued')) {
            $stylesFilePath = $componentManager->getComponentFilePath($componentName, 'style.scss');
            if (false !== $stylesFilePath) {
                $stylesFilePath = str_replace(trailingslashit(get_template_directory()), '', $stylesFilePath);
                $href = Asset::requireUrl($stylesFilePath);
                $output = str_replace(
                    '</head>',
                    "<link rel=\"stylesheet\" id=\"{$handle}\" href=\"{$href}\" />\n</head>",
                    $output
                );
            }
        }
    }

    return $output;
}, PHP_INT_MAX);

add_action('Flynt/afterRenderComponent', function ($componentName) {
    $componentManager = ComponentManager::getInstance();
    $stylesFilePath = $componentManager->getComponentFilePath($componentName, 'style.scss');
    if (false !== $stylesFilePath) {
        $stylesFilePath = str_replace(trailingslashit(get_template_directory()), '', $stylesFilePath);
        $url = Asset::requireUrl($stylesFilePath);
        $handle = "Flynt/assets/components{$componentName}";

        if (!wp_style_is($handle, 'registered')) {
            wp_register_style("Flynt/assets/components/{$componentName}", $url, [], null);
        }
    }
}, 1, 10);
