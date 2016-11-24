<?php

namespace WPStarterTheme\Hooks;

use WPStarterTheme\Helpers\Utils;

add_action('wp_enqueue_scripts', function () {
  wp_register_script('console-polyfill', Utils::requireAssetUrl('vendor/console.js'), [], null, true);
  wp_register_script('babel-polyfill', Utils::requireAssetUrl('vendor/babel-polyfill.js'), [], null, true);

  wp_enqueue_script(
    'assets/scripts',
    Utils::requireAssetUrl('assets/scripts/script.js'),
    ['console-polyfill', 'babel-polyfill'],
    null,
    true
  );
}, 100);
