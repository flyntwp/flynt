<?php
namespace WPStarterTheme\Modules\Oembed;

use WPStarterTheme\Helpers\Module;

add_image_size('wpsOembedLg', 1140, 700, true);
add_image_size('wpsOembedSm', 768, 500, true);

add_filter('WPStarter/modifyModuleData?name=Oembed', function ($data) {

  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }

  // Must have good pre-set image sizes. (add_image_size needs to live here)
  // Add you min/max image sizes in the fields.json config

  $imageConfig = [
    'default' => 'wpsOembedLg',
    'sizes' => [
      'wpsOembedSm' => '(max-width: 767px)'
    ]
  ];

  $data['posterImage']['imageConfig'] = $imageConfig;

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Oembed', [
    [
      'name' => 'fitvids',
      'path' => 'vendor/jquery.fitvids.js',
      'type' => 'script'
    ]
  ]);
});
