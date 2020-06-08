<?php

namespace Flynt\Components\FeatureAdminComponentScreenshots;

use Flynt\ComponentManager;
use Flynt\Utils\Asset;

add_action('admin_enqueue_scripts', function () {
    $componentManager = ComponentManager::getInstance();
    $templateDirectory = get_template_directory();
    $data = [
        'templateDirectoryUri' => get_template_directory_uri(),
        'components' => array_map(function ($componentPath) use ($templateDirectory) {
            return str_replace($templateDirectory, '', $componentPath);
        }, $componentManager->getAll()),
    ];
    wp_localize_script('Flynt/assets/admin', 'FlyntComponentScreenshots', $data);
});

if (class_exists('acf')) {
    if (is_admin()) {
        // add image to the flexible content component name
        add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
            $componentManager = ComponentManager::getInstance();
            $componentName = ucfirst($layout['name']);
            $componentPathFull = $componentManager->getComponentDirPath($componentName);
            $componentPath = str_replace(get_template_directory(), '', $componentPathFull);
            $templateDirectoryUri = get_template_directory_uri();
            $componentScreenshotPath = "{$componentPathFull}/screenshot.png";
            $componentScreenshotUrl = "{$templateDirectoryUri}/{$componentPath}/screenshot.png";
            if (is_file($componentScreenshotPath)) {
                $newTitle = '<span class="flyntComponentScreenshot">';
                $newTitle .= '<img class="flyntComponentScreenshot-imageElement" src="' . $componentScreenshotUrl . '" height="36px">';
                $newTitle .= '<span class="flyntComponentScreenshot-label">' . $title . '</span>';
                $newTitle .= '</span>';
                $title = $newTitle;
            }
            return $title;
        }, 11, 4);
    }
}
