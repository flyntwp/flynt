<?php
namespace Flynt\Theme\Modules\Oembed;

use Flynt\Theme\Helpers\Log;
use Flynt\Theme\Helpers\Module;
use Flynt\Theme\Helpers\DomNode;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Oembed');
});

add_filter('Flynt/modifyModuleData?name=Oembed', function ($data) {
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
