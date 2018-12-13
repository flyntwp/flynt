<?php
namespace Flynt\Features\Acf;

require_once __DIR__ . '/FlexibleContentToggle.php';
require_once __DIR__ . '/GoogleMaps.php';
require_once __DIR__ . '/Loader.php';

use Flynt\Features\Acf\Loader;
use Flynt\Utils\Feature;

Loader::setup(Feature::getOption('flynt-acf', 0));

add_action('Flynt/afterRegisterFeatures', 'Flynt\Features\Acf\Loader::init');

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
