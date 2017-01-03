<?php
namespace Flynt\Components\Oembed;

use Flynt\Helpers\Log;
use Flynt\Features\Components\Component;
use Flynt\Utils\DomNode;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('Oembed');
});

add_filter('Flynt/modifyComponentData?name=Oembed', function ($data) {
  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }

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
