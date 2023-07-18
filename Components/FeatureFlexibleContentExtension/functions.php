<?php

namespace Flynt\Components\FeatureFlexibleContentExtension;

use Flynt\ComponentManager;

add_action('admin_enqueue_scripts', function () {
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
add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
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
        $newTitle .= '<img class="flyntComponentScreenshot-previewImageSmall" width="' . $imageSize[0] . '" height="' . $imageSize[1] . '" src="' . $componentScreenshotUrl . '" loading="lazy">';
        $newTitle .= '<span class="flyntComponentScreenshot-label">' . $title . '</span>';
        $newTitle .= '</span>';
        $title = $newTitle;
    }
    return $title;
}, 11, 4);
