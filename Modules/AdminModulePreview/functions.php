<?php
namespace WPStarterTheme\Modules\AdminModulePreview;

use WPStarterTheme\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('AdminModulePreview');
});

if (class_exists('acf')) {

  if (is_admin()) {

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

  } else if (is_user_logged_in() && !is_admin()) {

    add_action('admin_bar_menu', function ($wpAdminBar) {
      $title = 'Module Previews';
      $wpAdminBar->add_menu([
        'id' => 'toggleModulePreviews',
        'title' => $title
      ]);
    });

  }

}
