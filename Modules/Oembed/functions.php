<?php
namespace WPStarterTheme\Modules\Oembed;

use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\DomNode;

add_image_size('wpsOembedLg', 1140, 700, true);
add_image_size('wpsOembedXs', 768, 500, true);

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Oembed');
});

add_filter('WPStarter/modifyModuleData?name=Oembed', function ($data) {

  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }

  // Must have good pre-set image sizes. (add_image_size needs to live here)
  // Add you min/max image sizes in the fields.json config

  $imageConfig = [
    'default' => 'wpsOembedLg',
    'sizes' => [
      'wpsOembedXs' => '(max-width: 767px)'
    ]
  ];

  $data['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
    $data['oembed'],
    'iframe',
    'src',
    [
      'autoplay' => 'true'
    ]
  );

  $data['posterImage']['imageConfig'] = $imageConfig;

  return $data;
});
