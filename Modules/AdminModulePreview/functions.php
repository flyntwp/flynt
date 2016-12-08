<?php
namespace WPStarterTheme\Modules\AdminModulePreview;

use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// @codingStandardsIgnoreLine
function enqueueModuleScripts() {
  Module::enqueueAssets('AdminModulePreview', [
    [
      'name' => 'draggabilly',
      'path' => 'vendor/draggabilly.js',
      'type' => 'script'
    ]
  ]);
  // add data to the javascript
  $data = [
    'templateDirectoryUri' => get_template_directory_uri()
  ];
  wp_localize_script('WPStarterTheme/Modules/AdminModulePreview', 'wpData', $data);
}

if (class_exists('acf')) {
  if (is_user_logged_in() || is_admin()) {
    add_action('admin_enqueue_scripts', NS . 'enqueueModuleScripts');
    add_action('wp_enqueue_scripts', NS . 'enqueueModuleScripts');

    if (is_admin()) {
      // add image to the flexible content module name
      add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
        $modulePath = "/Modules/$layout[name]/";
        $modulePreviewDesktopPath = get_template_directory() . $modulePath . 'preview-desktop.jpg';
        $modulePreviewDesktopUrl = get_template_directory_uri() . $modulePath . 'preview-desktop.jpg';

        if (is_file($modulePreviewDesktopPath)) {
          $newTitle = '<span class="layout-module-preview">';
          $newTitle .= '<img src="' . $modulePreviewDesktopUrl . '" height="36px">';
          $newTitle .= '<span class="label">' . $title . '</span>';
          $newTitle .= '</span>';
          $title = $newTitle;
        }
        return $title;
      }, 11, 4);

      // adds buttons to collapse/expand modules
      add_filter('acf/get_field_label', function ($label, $field) {
        if ($field['type'] === 'flexible_content') {
          $label .= '<span class="flexible-content-controls">';
          $label .= '<a class="acf-icon small -collapse collapse-all" title="collapse all"></a>';
          $label .= '<span class="-collapsed">';
          $label .= '<a class="acf-icon small -collapse expand-all" title="expand all"></a>';
          $label .= '</span></span>';
        }
        return $label;
      }, 10, 2);
    } else {
      // adds Module Previews button to admin bar on front-end when logged in
      add_action('admin_bar_menu', function ($wpAdminBar) {
        $title = 'Module Previews';
        $wpAdminBar->add_menu([
          'id' => 'toggleModulePreviews',
          'title' => $title
        ]);
      });
    }
  }
}
