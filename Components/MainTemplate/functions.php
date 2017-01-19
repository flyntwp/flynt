<?php

namespace Flynt\Components\MainTemplate;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=MainTemplate', function ($data) {
  $query = !empty($data['query']) ? $data['query'] : false;
  $post = Timber::get_post($query);
  if (!empty($post)) {
    $fields = get_fields($post->id);
    $post->fields = $fields === false ? [] : $fields;
  }
  $context = [
    'post' => $post
  ];
  return array_merge($context, $data);
});
