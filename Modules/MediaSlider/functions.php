<?php
namespace Flynt\Modules\MediaSlider;

use Flynt\Helpers\Utils;
use Flynt\Helpers\Log;
use Flynt\Helpers\Module;
use Flynt\Helpers\DomNode;

add_filter('Flynt/modifyModuleData?name=MediaSlider', function ($data) {
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
