<?php
namespace Flynt\Theme\Modules\MediaTextBlock;

use Flynt\Theme\Helpers\Module;
use Flynt\Theme\Helpers\Log;
use Flynt\Theme\Helpers\DomNode;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('MediaTextBlock');
});

add_filter('Flynt/modifyModuleData?name=MediaTextBlock', function ($data) {
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
