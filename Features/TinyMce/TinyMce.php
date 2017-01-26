<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class TinyMce extends Feature {
  public function setup() {
    // Clean Up TinyMCE Buttons

    // First Bar
    add_filter('mce_buttons', function ($buttons) {
      return array(
        'undo', 'redo', '|',
        'bold', 'bullist', 'numlist', '|',
        'link', 'unlink', 'copy', 'paste', '|',
        'cleanup', 'removeformat', 'formatselect');
    });

    // Second Bar
    add_filter('mce_buttons_2', function ($buttons) {
      return [];
    });
  }
}
