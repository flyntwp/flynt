<?php

namespace WPStarterTheme\DataFilters;

use WPStarterTheme\Helpers;
use WPStarterTheme\Helpers\Log;

add_filter('WPStarterTheme/DataFilters/Posts', ['WPStarterTheme\DataFilters\Posts', 'getPosts'], 10, 3);

class Posts {

  public static function getPosts($data, $postsPerPage, $contentType) {
    $posts = get_posts([
      'posts_per_page'   => $postsPerPage,
    ]);
    return array_map('self::reformatPost', $posts, array_fill(0, count($posts), $contentType));
  }

  protected static function reformatPost($post, $contentType) {
    $post->id = $post->ID;
    // @codingStandardsIgnoreStart
    $post->title = $post->post_title;
    $post->url = get_permalink($post->id);
    $post->image = get_the_post_thumbnail_url($post->id);
    if ($contentType === "short") {
      $post->content = Helpers\StringHelpers::trimStrip($post->post_content);
    } else {
      $post->content = $post->post_content;
    }
    // @codingStandardsIgnoreEnd
    return $post;
  }
}
