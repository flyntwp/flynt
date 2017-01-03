<?php
namespace Flynt\Components\Wysiwyg;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('Wysiwyg');
});

add_filter('Flynt/modifyComponentData?name=Wysiwyg', function ($data) {
  if (empty($data['theme'])) {
    $data['theme'] = get_field('defaultTheme', 'options');
  }
  return $data;
});
