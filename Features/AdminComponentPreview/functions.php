<?php
namespace Flynt\Features\AdminComponentPreview;

use Flynt\Features\Components\Component;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

function enqueueComponentScripts()
{
    Component::addAsset('register', [
    'type' => 'script',
    'name' => 'draggabilly',
    'path' => 'vendor/draggabilly.js'
    ]);

    Component::addAsset('enqueue', [
    'type' => 'script',
    'name' => 'Flynt/Features/AdminComponentPreview',
    'path' => 'Features/AdminComponentPreview/script.js',
    'dependencies' => ['jquery', 'draggabilly']
    ]);

    Component::addAsset('enqueue', [
    'type' => 'style',
    'name' => 'Flynt/Features/AdminComponentPreview',
    'path' => 'Features/AdminComponentPreview/style.css'
    ]);

    // add data to the javascript
    $data = [
    'templateDirectoryUri' => get_template_directory_uri()
    ];
    wp_localize_script('Flynt/Features/AdminComponentPreview', 'wpData', $data);
}

if (class_exists('acf')) {
    if (is_user_logged_in() || is_admin()) {
        if (is_admin()) {
            add_action('admin_enqueue_scripts', NS . 'enqueueComponentScripts');

            // add image to the flexible content component name
            add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
                $componentPath = "/Components/$layout[name]/";
                $componentPreviewDesktopPath = get_template_directory() . $componentPath . 'preview-desktop.jpg';
                $componentPreviewDesktopUrl = get_template_directory_uri() . $componentPath . 'preview-desktop.jpg';

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
                $title = __('Component Previews', 'flynt-theme');
                $wpAdminBar->add_menu([
                'id' => 'toggleComponentPreviews',
                'title' => $title
                ]);
            });
        }
    }
}
