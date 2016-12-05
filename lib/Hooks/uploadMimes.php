<?php

namespace WPStarterTheme\Hooks;

add_filter('upload_mimes', function ($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
});
