<?php

namespace Flynt\DataFilters;

use Timber\Timber;

add_filter('Flynt/DataFilters/MainQuery', ['Flynt\DataFilters\MainQuery', 'getQuery'], 10, 2);
add_filter('Flynt/DataFilters/MainQuery/Single', ['Flynt\DataFilters\MainQuery', 'getSingle'], 10, 2);

class MainQuery {

  public static function getQuery($data, $query = false) {
    if (!empty($query) && !empty(get_query_var('page'))) {
      $query['page'] = get_query_var('page');
    }
    $posts = array_map('self::addFieldsToPost', Timber::get_posts($query));
    $context = [
      'posts' => $posts
    ];
    return array_merge($context, $data);
  }

  public static function getSingle($data, $query = false) {
    $post = self::addFieldsToPost(Timber::get_post($query));
    $context = [
      'post' => $post
    ];
    return array_merge($context, $data);
  }

  protected static function addFieldsToPost($post) {
    if (!empty($post)) {
      $fields = get_fields($post->id);
      $post->fields = $fields === false ? [] : $fields;
    }
    return $post;
  }

}
