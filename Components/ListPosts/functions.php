<?php
namespace Flynt\Components\ListPosts;

use Flynt\Features\Components\Component;

use Timber\Timber;

define('NS', __NAMESPACE__ . '\\');

function getCategoryData($category) {
  return [
    'title' => $category->name,
    'permalink' => get_category_link($category->cat_ID)
  ];
}

function getTagData($tag) {
  return [
    'title' => $tag->name,
    'permalink' => get_category_link($tag->term_id)
  ];
}


add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('ListPosts');
});

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {
  $context = Timber::get_context();
  $context['posts'] = Timber::get_posts();

  $data['posts'] = array_map(function($post) {
    $categories = get_the_category($post->ID);
    $tags = get_the_tags($post->ID);

    if(!$categories)
      $categories = [];

    if(!$tags)
      $tags = [];

    return [
      'title' => $post->title,
      'excerpt' => $post->excerpt,
      'permalink' => get_the_permalink($post->ID),
      'thumbnail' => get_the_post_thumbnail_url($post->ID, 'full'),
      'date' => get_the_date('d.m.Y', $post->ID),
      'author' => get_the_author_meta('nicename', $post->post_author),
      'authorPermalink' => get_the_author_meta('url', $post->post_author),
      'categories' => array_map(NS . 'getCategoryData', $categories),
      'tags' => array_map(NS . 'getTagData', $tags)
    ];
  }, $context['posts']);

  return $data;
});
