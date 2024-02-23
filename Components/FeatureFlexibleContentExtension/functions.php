<?php

namespace Flynt\Components\FeatureFlexibleContentExtension;

use Flynt\ComponentManager;

add_action('admin_enqueue_scripts', function (): void {
    $componentManager = ComponentManager::getInstance();
    $templateDirectory = get_template_directory();
    $data = [
        'labels' => [
            'placeholder' => __('Search...', 'flynt'),
            'noResults' => __('No components found', 'flynt'),
        ],
        'templateDirectoryUri' => get_template_directory_uri(),
        'components' => array_map(function ($componentPath) use ($templateDirectory) {
            return str_replace($templateDirectory, '', $componentPath);
        }, $componentManager->getAll()),
    ];
    wp_localize_script('Flynt/assets/admin', 'FeatureFlexibleContentExtension', $data);
});

// add image to the flexible content component name
add_filter('acf/fields/flexible_content/layout_title', function (string $title, array $field, array $layout): string {
    $componentManager = ComponentManager::getInstance();
    $componentName = ucfirst($layout['name']);
    $componentPathFull = $componentManager->getComponentDirPath($componentName);
    $componentPath = str_replace(get_template_directory(), '', $componentPathFull);
    $templateDirectoryUri = get_template_directory_uri();
    $componentScreenshotPath = "{$componentPathFull}/screenshot.png";
    $componentScreenshotUrl = "{$templateDirectoryUri}/{$componentPath}/screenshot.png?v=" . wp_get_theme()->get('Version');

    if (is_file($componentScreenshotPath)) {
        $imageSize = getimagesize($componentScreenshotPath);
        $newTitle = '<span class="flyntComponentScreenshot">';
        $newTitle .= sprintf(
            '<img class="flyntComponentScreenshot-previewImageSmall" width="%s" height="%s" src="%s" loading="lazy">',
            $imageSize[0],
            $imageSize[1],
            $componentScreenshotUrl
        );
        $newTitle .= sprintf('<span class="flyntComponentScreenshot-label">%s</span>', $title);
        $newTitle .= '</span>';
        $title = $newTitle;
    }

    return $title;
}, 11, 4);
