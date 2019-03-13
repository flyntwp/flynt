<?php
namespace Flynt\Components\FeatureAcf;

require_once __DIR__ . '/FlexibleContentToggle.php';
require_once __DIR__ . '/GoogleMaps.php';
require_once __DIR__ . '/Loader.php';

use Flynt\Components\FeatureAcf\Loader;
use Flynt\Utils\Options;

Loader::setup([
    'FlexibleContentToggle',
    'GoogleMaps',
]);

add_action('Flynt/afterRegisterComponents', 'Flynt\Components\FeatureAcf\Loader::init', 1);

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

Options::addGlobal('Acf', [
    [
        'name' => 'googleMapsTab',
        'label' => 'Google Maps',
        'type' => 'tab'
    ],
    [
        'name' => 'googleMapsApiKey',
        'label' => 'Google Maps Api Key',
        'type' => 'text',
        'maxlength' => 100,
        'prepend' => '',
        'append' => '',
        'placeholder' => ''
    ]
]);
