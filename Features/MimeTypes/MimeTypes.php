<?php

namespace Flynt\Features;

use Flynt\Utils\Feature;

class MimeTypes extends Feature {
  public function setup() {
    add_filter('upload_mimes', function ($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    });
  }
}
