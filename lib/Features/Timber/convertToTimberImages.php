<?php

namespace Flynt\Hooks;

use Timber\Image;

add_filter('acf/format_value/type=image', function ($value) {
  if (!empty($value)) {
    $value = new Image($value);
  }
  return $value;
}, 100);
