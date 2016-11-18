<?php

namespace WPStarterTheme\Helpers;

use WPStarterTheme\Config;
use WPStarterTheme\Core;

class CustomPostTypeRegister {

  protected static function getConfigs($dir) {
    $configs = Core::iterateDirectory($dir, function ($file) {
      return self::processFile($file);
    }, 'json');

    return array_reduce($configs, function ($output, $config) {
      return array_merge($output, $config);
    }, []);
  }

  protected static function processFile($file) {
    $fileName = $file->getBasename('.json');
    return [
      $fileName => json_decode(file_get_contents($file->getPathname()), true)
    ];
  }

  public static function fromDirectory($dir) {
    $postTypesConfig = self::getConfigs($dir);
    if(empty($postTypesConfig)) return;

    foreach ($postTypesConfig as $config) {
      self::fromArray($config);
    }
  }

  public static function fromArray($config) {
    if (isset($config['labels'])) {
      $config['labels'] = array_map(function ($label) {
        return __($label, 'WPStarterTheme');
      }, $config['labels']);
    }

    $name = $config['name'];
    unset($config['name']);

    register_post_type($name, $config);
  }
}
