<?php

namespace Flynt\Features\Jquery;

use Flynt\Utils\Asset;
use Flynt\Utils\Feature;

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
