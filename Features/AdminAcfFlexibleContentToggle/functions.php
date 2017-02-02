<?php
namespace Flynt\Features\AdminAcfFlexibleContentToggle;

use Flynt\Features\Components\Component;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// @codingStandardsIgnoreLine
function enqueueComponentScripts() {
  Component::addAsset('enqueue', [
    'type' => 'script',
    'name' => 'AdminAcfFlexibleContentToggle',
    'path' => 'Features/AdminAcfFlexibleContentToggle/script.js'
  ]);

  Component::addAsset('enqueue', [
    'type' => 'style',
    'name' => 'AdminAcfFlexibleContentToggle',
    'path' => 'Features/AdminAcfFlexibleContentToggle/style.css'
  ]);
}

if (class_exists('acf')) {
  if (is_admin()) {
    add_action('admin_enqueue_scripts', NS . 'enqueueComponentScripts');
    // adds buttons to collapse/expand components
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
  }
}
