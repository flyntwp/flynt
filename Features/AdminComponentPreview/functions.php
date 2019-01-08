<?php
namespace Flynt\Features\AdminComponentPreview;

use Flynt\Utils\Asset;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('wp_enqueue_scripts', function () {
    if (is_user_logged_in()) {
        Asset::register([
            'type' => 'script',
            'name' => 'draggabilly',
            'path' => 'vendor/draggabilly.js'
        ]);
        Asset::addDependencies('Flynt/assets/auth', ['draggabilly']);
    }
    $data = [
        'templateDirectoryUri' => get_template_directory_uri() . '/dist',
    ];
    wp_localize_script('Flynt/assets/auth', 'wpData', $data);
});

add_action('admin_enqueue_scripts', function () {
    $data = [
        'templateDirectoryUri' => get_template_directory_uri() . '/dist',
    ];
    wp_localize_script('Flynt/assets/admin', 'wpData', $data);
});

if (class_exists('acf')) {
    if (is_user_logged_in() || is_admin()) {
        if (is_admin()) {
            // add image to the flexible content component name
            add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
                $componentName = ucfirst($layout['name']);
                $componentPath = "Components/{$componentName}";
                $componentPreviewDesktopPath = Asset::requirePath("{$componentPath}/preview-desktop.jpg");
                $componentPreviewDesktopUrl = Asset::requireUrl("{$componentPath}/preview-desktop.jpg");
                if (is_file($componentPreviewDesktopPath)) {
                    $newTitle = '<span class="flyntComponentPreview">';
                    $newTitle .= '<img class="flyntComponentPreview-imageElement" src="' . $componentPreviewDesktopUrl . '" height="36px">';
                    $newTitle .= '<span class="flyntComponentPreview-label">' . $title . '</span>';
                    $newTitle .= '</span>';
                    $title = $newTitle;
                }
                return $title;
            }, 11, 4);
        } else {
            // adds Component Previews button to admin bar on front-end when logged in
            add_action('admin_bar_menu', function ($wpAdminBar) {
                $title = __('Component Previews', 'flynt-starter-theme');
                $wpAdminBar->add_node([
                    'id' => 'toggleComponentPreviews',
                    'title' => $title,
                    'href' => '#'
                ]);
            }, 31);
        }
    }
}
