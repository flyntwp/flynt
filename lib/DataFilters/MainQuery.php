<?php

namespace WPStarterTheme\DataFilters;

use Timber\Timber;
use Timber\Post;

add_filter('WPStarterTheme/DataFilters/MainQuery', ['WPStarterTheme\DataFilters\MainQuery', 'getQuery']);
add_filter('WPStarterTheme/DataFilters/MainQuery/Single', ['WPStarterTheme\DataFilters\MainQuery', 'getSingle']);

class MainQuery {

  public static function getQuery($data) {
    $context = Timber::get_context();
    return array_merge($context, $data);
  }

  public static function getSingle($data) {
    $post = new Post();
    $context = [
      'post' => $post
    ];
    if (!empty($post)) {
      $post->fields = get_fields($post->id);
    }
    return array_merge($context, $data);
  }

}
