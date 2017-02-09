<?php

namespace Flynt\Components\NotFound;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('NotFound');
});

add_filter('Flynt/addComponentData?name=NotFound', function ($data) {
  $data['homeUrl'] = home_url();
  $data['text'] = get_field('notFoundText', 'options');
  $data['linkLabel'] = get_field('notFoundLinkLabel', 'options');
  return $data;
});

