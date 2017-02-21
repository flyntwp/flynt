<?php

namespace Flynt\Features\Acf;

use Flynt\Features\Components\Component;

class FlexibleContentToggle {

  public static function init() {
    self::addFlexibleContentControls();
  }

  public static function addFlexibleContentControls() {
    if (is_admin()) {
      add_action('admin_enqueue_scripts', ['Flynt\Features\Acf\FlexibleContentToggle', 'enqueueComponentScripts']);
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

  public static function enqueueComponentScripts() {
    Component::addAsset('enqueue', [
      'type' => 'script',
      'name' => 'AdminAcfFlexibleContentToggle',
      'path' => 'Features/Acf/admin.js',
      'dependencies' => ['jquery']
    ]);

    Component::addAsset('enqueue', [
      'type' => 'style',
      'name' => 'AdminAcfFlexibleContentToggle',
      'path' => 'Features/Acf/style.css'
    ]);
  }

}
