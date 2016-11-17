<?php

namespace WPStarterTheme\DataFilters;

use WP_Query;
use WPStarterTheme\Helpers\Utils;

add_filter('WPStarterTheme/DataFilters/MainQuery', ['WPStarterTheme\DataFilters\MainQuery', 'getQuery']);
add_filter('WPStarterTheme/DataFilters/MainQuery/Single', ['WPStarterTheme\DataFilters\MainQuery', 'getSingle']);

class MainQuery {
  protected static $bleechAcfFieldsQueried = false;

  public static function getQuery($data) {
    global $wp_query;
    $query = $wp_query;

    $posts = $query->posts;

    $posts = Utils::objectToArray($posts);

    $posts = self::addAdditionalDefaultData($posts);

    $output = array(
      'posts' => $posts,
      'meta' => array(
        'max_num_pages' => $query->max_num_pages,
        'current_page'  => max(1, $query->query_vars['paged'])
      )
    );
    wp_reset_query();

    return array_merge($data, $output);
  }

  public static function getSingle($data) {
    $queryResult = self::getQuery($data);
    $post = [];
    if(isset($queryResult['posts'][0])) {
      $post = $queryResult['posts'][0];
    }
    return array_merge($data, $post);
  }

  protected static function addAdditionalDefaultData($posts) {
    self::cachePostImages($posts);

    $posts = array_map(function($post) {
      $post['post_thumbnail'] = self::addPostThumbnail($post);
      $post['post_category'] = self::addPostCategory($post);
      $post['post_tags'] = self::addPostTags($post);
      $post['post_url'] = self::addPostPermalink($post);
      $post['post_date'] = self::addPostDate($post, array(
        'key' => 'post_date',
        'fmt' => '%d. %B %Y'
      ));
      if (class_exists('acf')) {
        $post = array_merge($post, self::getDataFromAcf($post['ID']));
      }
      return $post;
    }, $posts);

    return $posts;
  }

  protected static function getDataFromAcf($id = null) {
    // for caching
    if(!self::$bleechAcfFieldsQueried) {
      self::$bleechAcfFieldsQueried = true;
      $query = new WP_Query( array(
        'post_type' => array('acf-field-group', 'acf-field'),
        'posts_per_page' => -1,
        'post_status' => 'any'
      ) );
      wp_reset_query();
    }
    if (empty($id)) {
      return null;
    }
    $fields = get_fields($id);
    return empty($fields) ? [] : $fields;
  }

  protected static function cachePostImages($posts) {
    $ids = array();
    if(is_array($posts)) {
      foreach($posts as &$post) {
        $post_id = $post['ID'];
        if(has_post_thumbnail($post_id)) {
          $ids[] = (int) get_post_thumbnail_id( $post_id );
        }
      }
      new \WP_Query( array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'post__in' => $ids
      ) );
      wp_reset_query();
    }
  }

  protected static function addPostPermalink($post) {
    return get_permalink($post['ID']);
  }

  protected static function addPostAuthorName($post) {
    return get_the_author_meta('display_name', $post['post_author']);
  }

  protected static function addPostThumbnail($post) {
    return self::getPictureElementPostThumbnail($post['ID'], array('thumbnail'));
  }

  protected static function addPostCategory($post) {
    $categories = get_the_category($post['ID']);
    if(is_array($categories)) {
      return array_map(function($category) {
        $category = (array) $category;
        $category['link'] = get_category_link($category['term_id']);
        return $category;
      }, $categories);
    } else {
      return array();
    }
  }

  protected static function addPostTags($post) {
    $tags = get_the_tags($post['ID']);
    if(is_array($tags) && !empty($tags)) {
      return array_map(function($tag) {
        $tag = (array) $tag;
        $tag['link'] = get_tag_link($tag['term_id']);
        return $tag;
      }, $tags);
    } else {
      return array();
    }
  }

  protected static function addPostDate($post, $args) {
    return utf8_encode(strftime($args['fmt'], strtotime($post[$args['key']])));
  }

  protected static function getPictureElementPostThumbnail($post_id) {
    if(has_post_thumbnail($post_id)) {
      $post_thumbnail_id = get_post_thumbnail_id( $post_id );
      if (class_exists('acf') && function_exists('acf_get_attachment')) {
        return acf_get_attachment($post_thumbnail_id);
      }
      return wp_get_attachment_image($post_thumbnail_id);
    } else {
      return array();
    }
  }
}
