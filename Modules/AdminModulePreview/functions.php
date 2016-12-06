<?php
namespace WPStarterTheme\Modules\AdminModulePreview;

use WPStarterTheme\Helpers\Module;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

add_action('admin_enqueue_scripts', NS . 'enqueueModuleScripts');
add_action('wp_enqueue_scripts', NS . 'enqueueModuleScripts');

// @codingStandardsIgnoreLine
function enqueueModuleScripts() {
  Module::enqueueAssets('AdminModulePreview');
  // add data to the javascript
  $data = [
    'templateDirectoryUri' => get_template_directory_uri()
  ];
  wp_localize_script('WPStarterTheme/Modules/AdminModulePreview', 'wpData', $data);
}

if (class_exists('acf')) {

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

  } else if (is_user_logged_in() && !is_admin()) {

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
