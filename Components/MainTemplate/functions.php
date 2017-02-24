<?php

namespace Flynt\Components\MainTemplate;

use Timber\Timber;
use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('MainTemplate');
});

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
  return array_merge(getPasswordContext($post->ID), $context, $data);
});

function getPasswordContext ($postId) {
  $passwordProtected = post_password_required($postId);
  return [
    'passwordProtected' => $passwordProtected,
    'passwordForm' => $passwordProtected ? get_the_password_form() : ''
  ];
}
