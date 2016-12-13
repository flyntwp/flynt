<?php
namespace Flynt\Components\MediaTextBlock;

use Flynt\Helpers\Component;
use Flynt\Helpers\Log;
use Flynt\Helpers\DomNode;

add_action('wp_enqueue_scripts', function () {
  Component::enqueueAssets('MediaTextBlock');
});

add_filter('Flynt/modifyComponentData?name=MediaTextBlock', function ($data) {
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
