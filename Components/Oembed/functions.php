<?php
namespace Flynt\Components\Oembed;

use Flynt\Features\Components\Component;
use Flynt\Utils\DomNode;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('Oembed');
});

add_filter('Flynt/addComponentData?name=Oembed', function ($data) {
  $data['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
    $data['oembed'],
    'iframe',
    'src',
    [
      'autoplay' => 'true'
    ]
  );

  return $data;
});
