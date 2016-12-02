<?php
namespace WPStarterTheme\Modules\MediaTextBlock;

use WPStarterTheme\Helpers\Module;

add_action('wp_enqueue_scripts', function () {
  Module::enqueueAssets('Wysiwyg');
});

// Must have good pre-set image sizes. (add_image_size needs to live here)
// Add you min/max image sizes in the fields.json config

add_filter('WPStarter/modifyModuleData?name=MediaTextBlock', function ($data) {
  if (empty($data['mediaType'] == 'video' && $data['posterImage'])  ) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }
  return $data;
});
