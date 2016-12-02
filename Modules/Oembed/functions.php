<?php
use WPStarterTheme\Helpers\Log;

add_filter('WPStarter/modifyModuleData?name=Oembed', function ($data) {
  if (empty($data['posterImage'])) {
    $data['posterImage'] = get_field('defaultPosterImage', 'options');
  }
  return $data;
});
