<?php

namespace WPStarterTheme\Hooks;

/**
 * registerJquery
 *
 * Load jQuery from jQuery's CDN
 *
 * TODO add local fallback
 *
 */
add_action('wp_enqueue_scripts', function () {
  $jqueryVersion = wp_scripts()->registered['jquery']->ver;
  wp_deregister_script('jquery');
  wp_register_script(
    'jquery',
    '//code.jquery.com/jquery-' . $jqueryVersion . '.min.js',
    [],
    null,
    true
  );
}, 100);
