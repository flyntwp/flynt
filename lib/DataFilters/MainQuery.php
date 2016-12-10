<?php

namespace WPStarterTheme\DataFilters;

use Timber\Timber;
use Timber\Post;

add_filter('WPStarterTheme/DataFilters/MainQuery', ['WPStarterTheme\DataFilters\MainQuery', 'getQuery']);
add_filter('WPStarterTheme/DataFilters/MainQuery/Single', ['WPStarterTheme\DataFilters\MainQuery', 'getSingle']);

class MainQuery {

  public static function getQuery($data) {
    $posts = array_map('self::addFieldsToPost', Timber::get_posts());
    $context = [
      'posts' => $posts
    ];
    return array_merge($context, $data);
  }

  public static function getSingle($data) {
    $post = self::addFieldsToPost(new Post());
    $context = [
      'post' => $post
    ];
    return array_merge($context, $data);
  }

  protected static function addFieldsToPost($post) {
    if (!empty($post)) {
      $post->fields = get_fields($post->id);
    }
    return $post;
  }

}
