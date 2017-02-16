<?php

namespace Flynt\Components\MainTemplate;

use Timber\Timber;
use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('MainTemplate', [
    [
      'name' => 'console-polyfill',
      'type' => 'script',
      'path' => 'vendor/console.js'
    ],
    [
      'name' => 'babel-polyfill',
      'type' => 'script',
      'path' => 'vendor/babel-polyfill.js'
    ],
    [
      'name' => 'document-register-element',
      'type' => 'script',
      'path' => 'vendor/document-register-element.js'
    ],
    [
      'name' => 'picturefill',
      'path' => 'vendor/picturefill.js',
      'type' => 'script'
    ],
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ]
  ]);
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
  return array_merge($context, $data);
});
