<?php

namespace Flynt\Features\Acf;

class GoogleMap {
  public static function init() {
    add_filter('acf/fields/google_map/api', function ($api) {
      $apiKey = OptionPages::getOption('options', 'feature', 'Acf', 'googleMapsApiKey');
      if ($apiKey) {
        $api['key'] = $apiKey;
      }
      return $api;
    });
  }
}
