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

// Register component stylesheets only when a component is rendered.
add_filter('Flynt/renderComponent', function ($output, $componentName) {
    $componentManager = ComponentManager::getInstance();
    $stylesFilePath = $componentManager->getComponentFilePath($componentName, 'style.scss');
    if (false !== $stylesFilePath) {
        $stylesFilePath = str_replace(trailingslashit(get_template_directory()), '', $stylesFilePath);
        $url = Asset::requireUrl($stylesFilePath);
        $handle = "Flynt/Components/{$componentName}";

        if (!wp_style_is($handle, 'registered')) {
            wp_register_style("Flynt/Components/{$componentName}", $url, [], null);
        }
    }

    return $output;
}, 10, 2);

// Add component stylesheets to the head.
add_filter('timber/compile/result', function ($output) {
    if (strpos($output, '<!DOCTYPE html>') === false) {
        return $output;
    }

    global $wp_styles;
    if (empty($wp_styles) || empty($wp_styles->registered)) {
        return $output;
    }

    $filteredStyles = array_filter($wp_styles->registered, function ($style) {
        return isset($style->handle) && strpos($style->handle, 'Flynt/Components/') === 0;
    });

    $styleLinksContent = '';
    foreach ($filteredStyles as $style) {
        if (isset($style->src) && !empty($style->src)) {
            ob_start();
            $success = $wp_styles->do_item($style->handle);
            $styleContent = ob_get_clean();

            if (!$success) {
                continue;
            }

            $styleLinksContent .= $styleContent;
        }
    }

    return str_replace('</head>', $styleLinksContent . '</head>', $output);
}, PHP_INT_MAX);
