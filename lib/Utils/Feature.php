<?php

namespace Flynt\Utils;

class Feature {
  protected $options;
  protected $dir;

  private static $features = [];

  public function __construct($options, $dir) {
    $this->options = $options;
    $this->dir = $dir;

    $this->setup();
  }

  public function setup() {
    // to be overwritten in child
  }

  public function init() {
    // to be overwritten in child
  }

  public function getOptions() {
    return $this->options;
  }

  public function getOption($key) {
    return array_key_exists($key, $this->options) ? $this->options[$key] : null;
  }

  public function getDir() {
    return $this->dir;
  }

  public static function register($feature, $dirPath, $options = []) {
    if (!isset(self::$features[$feature])) {
      $options = (array) $options;

      // require main feature file
      $dirName = ucfirst(basename($dirPath));
      $file = "{$dirPath}/{$dirName}.php";

      if (is_file($file)) require_once $file;

      $className = "Flynt\Features\\{$dirName}";

      if (class_exists($className)) {

        // add feature instance to list
        self::$features[$feature] = new $className($options, $dirPath);

      } else {

        trigger_error("Could not register feature: {$feature}!", E_USER_WARNING);
        return false;

      }

      // execute post register actions
      do_action('Flynt/registerFeature', $feature, $options, $dirPath);
      do_action("Flynt/registerFeature?name={$feature}", $feature, $options, $dirPath);
    }
  }

  public static function initAllFeatures() {
    foreach (self::$features as $featureName => $feature) {
      $feature->init();

      // execute post init actions
      $options = $feature->getOptions();
      $dir = $feature->getDir();

      do_action('Flynt/initFeature', $featureName, $options, $dir);
      do_action("Flynt/initFeature?name={$featureName}", $featureName, $options, $dir);
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

  public static function setInitialFile($fileName) {
    self::$initialFile = $fileName;
  }
}
