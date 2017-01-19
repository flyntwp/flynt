<?php

namespace Flynt\Utils;

class Feature {
  protected static $initialFile = 'functions.php';
  protected static $features = [];

  public static function init($feature, $dir, $options = []) {
    if (!isset(self::$features[$feature])) {
      self::$features[$feature] = [
        'directory' => $dir,
        'options' => (array) $options
      ];

      $file = $dir . '/' . self::$initialFile;
      if (is_file($file)) require_once $file;
    }
  }

  public static function getActiveFeatures() {
    return self::$features;
  }

  public static function isActive($name) {
    return array_key_exists($name, self::$features);
  }

  public static function getOptions($feature) {
    if (isset(self::$features[$feature])) {
      return self::$features[$feature]['options'];
    }
  }

  public static function getDirectory($feature) {
    if (isset(self::$features[$feature])) {
      return self::$features[$feature]['directory'];
    }
  }

  public static function setInitialFile($fileName) {
    self::$initialFile = $fileName;
  }
}
