<?php
namespace WPStarterTheme\Modules\MediaTextBlock;

use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\DomNode;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('MediaTextBlock');
});

add_filter('WPStarter/modifyModuleData?name=MediaTextBlock', function ($data) {
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
