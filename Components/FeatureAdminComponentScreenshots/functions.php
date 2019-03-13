<?php
namespace Flynt\Components\AdminComponentScreenshots;

use Flynt\Utils\Asset;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('admin_enqueue_scripts', function () {
    $data = [
        'templateDirectoryUri' => get_template_directory_uri() . '/dist',
    ];
    wp_localize_script('Flynt/assets/admin', 'wpData', $data);
});

if (class_exists('acf')) {
    if (is_admin()) {
        // add image to the flexible content component name
        add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
            $componentName = ucfirst($layout['name']);
            $componentPath = "Components/{$componentName}";
            $componentScreenshotPath = Asset::requirePath("{$componentPath}/screenshot.png");
            $componentScreenshotUrl = Asset::requireUrl("{$componentPath}/screenshot.png");
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
