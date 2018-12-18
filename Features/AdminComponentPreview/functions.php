<?php
namespace Flynt\Features\AdminComponentPreview;

use Flynt\Utils\Asset;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

function enqueueComponentScripts()
{
    Asset::register([
        'type' => 'script',
        'name' => 'draggabilly',
        'path' => 'vendor/draggabilly.js'
    ]);

    Asset::enqueue([
        'type' => 'script',
        'name' => 'Flynt/Features/AdminComponentPreview',
        'path' => 'Features/AdminComponentPreview/script.js',
        'dependencies' => ['jquery', 'draggabilly']
    ]);

    Asset::enqueue([
        'type' => 'style',
        'name' => 'Flynt/Features/AdminComponentPreview',
        'path' => 'Features/AdminComponentPreview/style.css'
    ]);

    // add data to the javascript
    $data = [
        'templateDirectoryUri' => get_template_directory_uri() . '/dist'
    ];
    wp_localize_script('Flynt/Features/AdminComponentPreview', 'wpData', $data);
}

if (class_exists('acf')) {
    if (is_user_logged_in() || is_admin()) {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', NS . 'enqueueComponentScripts');
            // add image to the flexible content component name
            add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
                $componentName = ucfirst($layout['name']);
                $componentPath = "Components/{$componentName}";
                $componentPreviewDesktopPath = Asset::requirePath("{$componentPath}/preview-desktop.jpg") ;
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
            add_action('wp_enqueue_scripts', NS . 'enqueueComponentScripts');
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
