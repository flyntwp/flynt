<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class Templates extends Feature {
  public function setup() {
    // Set Config Path
    add_filter('Flynt/configPath', function ($filePath, $fileName) {
      return get_template_directory() . '/config/templates/' . $fileName;
    }, 10, 2);
  }
}
