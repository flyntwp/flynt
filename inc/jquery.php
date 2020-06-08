<?php

/**
 * Loads jQuery before the closing body tag by default. Can be overwritten if there is a script in the head with jQuery as a dependency.
 *
 * If the Asset utility has `loadFromCdn` set to true, it will load from Google's CDN falling back to the default WordPress script. This setting can be changed in the `lib/Init.php` file inside the `initTheme` function.
 */

namespace Flynt\Jquery;

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    $jqueryVersion = wp_scripts()->registered['jquery']->ver;
    wp_deregister_script('jquery');

    $jqueryLocalUrl = esc_url(includes_url("/js/jquery/jquery.js?ver=${jqueryVersion}"));
    Asset::register([
        'name' => 'jquery',
        'cdn' => [
            'url' => "//ajax.googleapis.com/ajax/libs/jquery/${jqueryVersion}/jquery.min.js",
            'check' => 'window.jQuery'
        ],
        'type' => 'script',
        'path' => $jqueryLocalUrl
    ]);
}, 0); // NOTE: prio needs to be < 1
