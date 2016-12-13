<?php

use Timber\Timber;

add_filter('Flynt/DataFilters/WpBase', function ($data) {
  $context = Timber::get_context();

  $output = array(
    'appleTouchIcon180x180Path' => get_template_directory_uri() . '/apple-touch-icon-180x180.png',
    'faviconPath' => get_template_directory_uri() . '/favicon.png',
    'feedTitle' => $context['site']->name . ' ' . __('Feed'),
    'dir' => is_rtl() ? 'rtl' : 'ltr'
  );

  return array_merge($context, $data, $output);
});
