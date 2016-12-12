<?php
namespace WPStarterTheme\Modules\MediaSlider;

use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Helpers\Log;
use WPStarterTheme\Helpers\Module;
use WPStarterTheme\Helpers\DomNode;

add_image_size('wpsMediaSliderLg', 1140, 700, true);
add_image_size('wpsMediaSliderSm', 768, 500, true);

add_filter('WPStarter/modifyModuleData?name=MediaSlider', function ($data) {
  $data['mediaSlides'] = array_map(function ($item) {
    if ($item['mediaType'] == 'oembed') {
      $item['oembedLazyLoad'] = DomNode::setSrcDataAttribute(
        $item['oembed'],
        'iframe',
        'src',
        [
          'autoplay' => 'true'
        ]
      );
    }
    return $item;
  }, $data['mediaSlides']);

  // Show a title/caption for the Media Slider - true | false
  $data['mediaSliderTitle'] = true;

  // Should the Media Slider Title be above or below the slide? - above | below
  $data['mediaSliderTitlePosition'] = 'below';

  $data['mediaSliderUsePoster'] = true;

  return $data;
});

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('MediaSlider', [
    [
      'name' => 'normalize',
      'path' => 'vendor/normalize.css',
      'type' => 'style'
    ],
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.js',
      'type' => 'script'
    ],
    [
      'name' => 'slick-carousel',
      'path' => 'vendor/slick.css',
      'type' => 'style'
    ]
  ]);
});
