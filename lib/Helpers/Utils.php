<?php

namespace WPStarterTheme\Helpers;

use function WPStarter\registerModule;
use WPStarter\Defaults;
use RecursiveDirectoryIterator;

class Utils {
  public static function OutputBufferContents($funcName, $args = null) {
    ob_start();
    if (isset($args)) {
      $funcName($args);
    } else {
      $funcName();
    }
    $output = ob_get_contents();
    ob_get_clean();
    return $output;
  }

  public static function registerAllModules() {
    $directory = Defaults::getModulesDirectory();

    // TODO use new Core functionality after adding the feature for dirs
    $directoryIterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($directoryIterator as $name => $file) {
      if ($file->isDir()) {
        registerModule($file->getFilename());
      }
    }
  }

  public static function isAssoc(array $array) {
    // Keys of the array
    $keys = array_keys($array);

    // If the array keys of the keys match the keys, then the array must
    // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
    return array_keys($keys) !== $keys;
  }

  // only converts first dimension of object
  public static function objectToArray($obj) {
    return array_map(function ($val) {
      return (array) $val;
    }, $obj);
  }
}
