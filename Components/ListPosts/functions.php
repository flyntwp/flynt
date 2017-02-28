<?php
namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

use Timber\Timber;
use Flynt\Utils\Log;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ListPosts');
});

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {
  $queries = getQueries();
  if ($queries) {
    $args = [
      'post_type' => 'post'
    ];
    $pagination = Timber::get_pagination();
    $args = array_merge($args, $queries);
    $args['paged'] = $pagination['current'];
    $data['posts'] = Timber::get_posts($args);
  } else {
    $data['posts'] = Timber::get_posts();
  }

  return $data;
});

// @codingStandardsIgnoreLine
function getQueries() {
  $queries = [];
  if (isset($_GET['category'])) {
    $queries['category_name'] = $_GET['category'];
  }

  if (isset($_GET['filtertag'])) {
    $queries['tag'] = $_GET['filtertag'];
  }

  if (count($queries) === 0) {
    $queries = false;
  }

  return $queries;
}
