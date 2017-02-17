<?php
namespace Flynt\Components\MediaTextBlock;

use Flynt\Features\Components\Component;
use Flynt\Utils\Log;
use Flynt\Utils\DomNode;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('MediaTextBlock');
});

add_filter('Flynt/addComponentData?name=MediaTextBlock', function ($data) {
  if (empty($data['mediaType'] == 'mediaVideo' && $data['posterImage'])  ) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }

  if ($data['mediaType'] === 'mediaVideo') {
    $data['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
      $data['oembed'],
      'iframe',
      'src',
      [
        'autoplay' => 'true'
      ]
    );
  }

  return $data;
});
