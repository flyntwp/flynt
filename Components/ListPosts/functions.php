<?php
namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

use Timber\Timber;

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

  $data['isArchive'] = is_archive();

  $data['archiveTitle'] = '';
  $data['filterTitle'] = '';

  if (is_category()) {
    $data['archiveTitle'] = single_cat_title('', false);
    $data['filterTitle'] = $data['categoryLabel'] . ': ';
  } elseif (is_tag()) {
    $data['archiveTitle'] = single_tag_title('', false);
    $data['filterTitle'] = $data['tagLabel'] . ': ';
  } elseif (is_author()) {
    $data['archiveTitle'] = get_the_author();
    $data['filterTitle'] = $data['authorLabel'] . ': ';
  } elseif (is_post_type_archive()) {
    $data['archiveTitle'] = post_type_archive_title('', false);
  } elseif (is_tax()) {
    $data['archiveTitle'] = single_term_title('', false);
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
