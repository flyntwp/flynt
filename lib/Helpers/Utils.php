<?php

namespace WPStarterTheme\Helpers;

class Utils {
  protected static $assetManifest;

  public static function outputBufferContents($funcName, $args = null) {
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

  public static function requireAssetUrl($asset) {
    $distPath = get_template_directory() . '/dist';
    $distUrl = get_template_directory_uri() . '/dist';
    if (!isset(self::$assetManifest)) {
      $manifestPath = $distPath . '/rev-manifest.json';
      if (is_file($manifestPath)) {
        self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
      } else {
        self::$assetManifest = [];
      }
    }
    if (array_key_exists($asset, self::$assetManifest)) {
      $assetSuffix = self::$assetManifest[$asset];
    } else {
      $assetSuffix = $asset;
    }
    return $distUrl . '/' . $assetSuffix;
  }

  public static function requireAssetPath($asset) {
    $distPath = get_template_directory() . '/dist';
    $distUrl = get_template_directory_uri() . '/dist';
    if (!isset(self::$assetManifest)) {
      $manifestPath = $distPath . '/rev-manifest.json';
      if (is_file($manifestPath)) {
        self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
      } else {
        self::$assetManifest = [];
      }
    }
    if (array_key_exists($asset, self::$assetManifest)) {
      $assetSuffix = self::$assetManifest[$asset];
    } else {
      $assetSuffix = $asset;
    }
    return $distPath . '/' . $assetSuffix;
  }
}
