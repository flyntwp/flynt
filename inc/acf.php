<?php

namespace Flynt\Acf;

use Flynt\Utils\Options;

add_filter('pre_http_request', function ($preempt, $args, $url) {
    if (strpos($url, 'https://www.youtube.com/oembed') !== false || strpos($url, 'https://vimeo.com/api/oembed') !== false) {
        $response = wp_cache_get($url, 'oembedCache');
        if (!empty($response)) {
            return $response;
        }
    }
    return false;
}, 10, 3);

add_filter('http_response', function ($response, $args, $url) {
    if (strpos($url, 'https://www.youtube.com/oembed') !== false || strpos($url, 'https://vimeo.com/api/oembed') !== false) {
        wp_cache_set($url, $response, 'oembedCache');
    }
    return $response;
}, 10, 3);

add_filter('acf/fields/google_map/api', function ($api) {
    $apiKey = Options::getGlobal('Acf', 'googleMapsApiKey');
    if ($apiKey) {
        $api['key'] = $apiKey;
    }
    return $api;
});

Options::addGlobal('Acf', [
    [
        'name' => 'googleMapsTab',
        'label' => __('Google Maps', 'flynt'),
        'type' => 'tab'
    ],
    [
        'name' => 'googleMapsApiKey',
        'label' => __('Google Maps Api Key', 'flynt'),
        'type' => 'text',
        'maxlength' => 100,
        'prepend' => '',
        'append' => '',
        'placeholder' => ''
    ]
]);
