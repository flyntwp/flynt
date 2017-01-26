<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class Navigation extends Feature {
  public function setup() {
    add_action('after_setup_theme', function () {
      register_nav_menus(array(
        'main_navigation' => __('Main Navigation', 'flynt-theme'),
        'footer_navigation' => __('Footer Navigation', 'flynt-theme')
      ));
    });
  }
}
