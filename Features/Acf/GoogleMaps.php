<?php

namespace Flynt\Features\Acf;

class GoogleMaps
{
    public static function init()
    {
        add_filter('acf/fields/google_map/api', function ($api) {
            $apiKey = OptionPages::get('globalOptions', 'feature', 'Acf', 'googleMapsApiKey');
            if ($apiKey) {
                $api['key'] = $apiKey;
            }
            return $api;
        });
    }
}
