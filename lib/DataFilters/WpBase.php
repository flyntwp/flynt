<?php

use WPStarterTheme\Helpers\Utils;

add_filter('WPStarterTheme/DataFilters/WpBase', function ($data) {
  $output = array(
    'lang' => get_bloginfo('language'),
    'feedName' => get_bloginfo('name') . " " . __("Feed"),
    'feedHref' => esc_url(get_feed_link()),
    'bodyClass' => join(' ', get_body_class()),
    'appleTouchIcon180x180Path' => get_template_directory_uri() . '/apple-touch-icon-180x180.png',
    'faviconPath' => get_template_directory_uri() . '/favicon.png',
    // TODO Do this in the template
    'wpFooter' => Utils::OutputBufferContents('wp_footer'),
    'wpHead' => Utils::OutputBufferContents('wp_head')
  );

  if (is_rtl()) {
    $output['dir'] = 'rtl';
  } else {
    $output['dir'] = 'ltr';
  }

  return array_merge($data, $output);
});
