<?php

namespace Flynt\Features\Acf;

use Flynt\Utils\Options;

class GoogleMaps
{
    public static function init()
    {
        add_filter('acf/fields/google_map/api', function ($api) {
            $apiKey = Options::get('globalOptions', 'feature', 'Acf', 'googleMapsApiKey');
            if ($apiKey) {
                $api['key'] = $apiKey;
            }
            return $api;
        });
    }
}
