<?php

namespace Flynt\Components\PaginationButtons;

use Flynt\Features\Components\Component;
use Timber\Timber;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('PaginationButtons');
});

add_filter('Flynt/addComponentData?name=PaginationButtons', function ($data) {
  $data['pagination'] = Timber::get_pagination();
  return $data;
});
