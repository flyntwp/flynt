<?php

namespace Flynt\Utils;

class Feature {

  private static $initialFile = 'functions.php';
  private static $features = [];

  public static function getOptions($feature) {
    $feature = self::getFeature($feature);
    return $feature ? $feature['options'] : null;
  }

  public static function getOption($feature, $key) {
    $options = self::getOptions($feature);
    return is_array($options) && array_key_exists($key, $options) ? $options[$key] : null;
  }

  public static function getDir($feature) {
    $feature = self::getFeature($feature);
    return $feature ? $feature['dir'] : null;
  }

  public static function register($feature, $basePath, $options = []) {
    if (!isset(self::$features[$feature])) {

      $prettyName = StringHelpers::removePrefix('flynt', StringHelpers::kebapCaseToCamelCase($feature));
      $dir = implode('/', [$basePath, $prettyName]);
      $file = implode('/', [$dir, self::$initialFile]);

      if (is_file($file)) {

        $options = (array) $options;

        self::$features[$feature] = [
          'options' => $options,
          'dir' => $dir
        ];

        require_once $file;

        // execute post register actions
        do_action('Flynt/registerFeature', $feature, $options, $dir);
        do_action("Flynt/registerFeature?name={$prettyName}", $feature, $options, $dir);

        return true;

      }

      trigger_error("{$feature}: Could not register feature! File not found: {$file}", E_USER_WARNING);

      return false;

    }
  }

  public static function isRegistered($name) {
    return array_key_exists($name, self::$features);
  }

  public static function getFeature($name) {
    if (isset(self::$features[$name])) {
      return self::$features[$name];
    }
    return false;
  }

  public static function getFeatures() {
    return self::$features;
  }

  public static function setInitialFile($fileName) {
    self::$initialFile = $fileName;
  }
}
