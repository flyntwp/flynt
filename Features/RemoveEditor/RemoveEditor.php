<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class RemoveEditor extends Feature {
  public function setup() {
    add_action('init', function () {
      remove_post_type_support('page', 'editor');
      remove_post_type_support('post', 'editor');
    });
  }
}
