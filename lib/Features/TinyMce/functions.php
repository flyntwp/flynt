<?php

namespace Flynt\Features\TinyMce;

// Clean Up Buttons of TinyMCE

// First Bar
add_filter('mce_buttons', function ($buttons) {
  return array(
    'undo', 'redo', '|',
    'bold', 'bullist', 'numlist', '|',
    'link', 'unlink', 'copy', 'paste', '|',
    'cleanup', 'removeformat', 'formatselect');
});

// Second Bar
add_filter('mce_buttons_2', function ($buttons) {
  return [];
});
