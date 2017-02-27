<?php
namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

use Timber\Timber;
use Flynt\Utils\Log;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ListPosts');
});

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {
  $data['posts'] = Timber::get_posts();
  return $data;
});
