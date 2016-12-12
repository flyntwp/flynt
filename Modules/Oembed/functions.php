<?php
namespace WPStarterTheme\Modules\Oembed;

use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\DomNode;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Oembed');
});

add_filter('WPStarter/modifyModuleData?name=Oembed', function ($data) {
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
