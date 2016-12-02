<?php

namespace WPStarterTheme\Hooks;

add_filter('mce_buttons', function ($buttons) {
  return array(
    'undo', 'redo', '|',
    'bold', 'bullist', 'numlist', '|',
    'link', 'unlink', 'copy', 'paste', '|',
    'cleanup', 'removeformat', 'formatselect');
});

add_filter('mce_buttons_2', function ($buttons) {
  return [];
});
