<?php

namespace WPStarterTheme\Helpers;

use WPStarterTheme\Config;

class CustomPostTypeLoader {
  public static function getConfigs() {
    $customPostTypesPath = Config\CONFIG_PATH . 'customPostTypes/';
    $postTypesConfig = [];
    if(file_exists($customPostTypesPath)) {
      foreach(scandir($customPostTypesPath) as $postTypePath) {
        if(strpos($postTypePath, '.json')) {
          $postTypeName = str_replace('.json', '', $postTypePath);
          $postTypePath = $customPostTypesPath . $postTypePath;
          $postTypesConfig[$postTypeName] = json_decode(file_get_contents($postTypePath), true);
        }
      }
    }
    return $postTypesConfig;
  }

  public static function registerCustomPostTypes() {
    $postTypesConfig = self::getConfigs();
    if(empty($postTypesConfig)) return;
    $postTypesConfig = array_map(function ($postType) {
      $postType['labels'] = array_map(function ($label) {
        return __($label);
      }, $postType['labels']);
      return $postType;
    }, $postTypesConfig);
    foreach($postTypesConfig as $config) {
      $name = $config['name'];
      unset($config['name']);
      register_post_type($name, $config);
    }
  }
}
