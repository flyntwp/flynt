<?php
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=Oembed', function ($data) {
  
  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }

  // Must have good pre-set image sizes. (add_image_size needs to live here)
  // Add you min/max image sizes in the fields.json config

  return $data;
});
