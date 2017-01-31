<?php

namespace Flynt\Features\CustomPostTypes;

use Flynt;
use Flynt\Utils\FileLoader;

class CustomPostTypeRegister {

  private static $fileName;
  private static $registeredCustomPostTypes = [];

  public static function fromDir($dir, $fileName) {
    self::$fileName = $fileName;

    $postTypesConfig = self::getConfigs($dir);

    if(empty($postTypesConfig)) return;

    foreach ($postTypesConfig as $config) {
      self::fromArray($config);

      do_action(
        'Flynt/Features/CustomPostTypes/Register',
        $config['name'],
        self::$registeredCustomPostTypes[$config['name']]
      );
    }
  }

  public static function fromArray($config) {
    $config = apply_filters(
      'Flynt/Features/CustomPostTypes/TranslateConfig',
      self::translateConfig($config)
    );

    $config = apply_filters(
      "Flynt/Features/CustomPostTypes/TranslateConfig?name={$config['name']}",
      $config
    );

    $name = $config['name'];
    unset($config['name']);

    if (!is_wp_error(register_post_type($name, $config))) {
      self::$registeredCustomPostTypes[$name]['config'] = $config;
    }
  }

  protected static function translateConfig($config) {
    $config['label'] = self::translate($config, 'label');
    $config['labels'] = self::translate($config, 'labels');
    $config['singular_label'] = self::translate($config, 'singular_label');
    $config['description'] = self::translate($config, 'description');
    $config['rewrite']['slug'] = self::translate($config, 'rewrite', 'slug');

    return self::cleanConfig($config);
  }

  // ...$args works in PHP 5.6+
  protected static function translate(...$args) {
    if (count($args) === 0) {
      trigger_error('Invalid argument count for translation!', E_USER_WARNING);
      return [];
    }

    if (count($args) === 1) {
      return $args[0];
    }

    $value = Flynt\Helpers::extractNestedDataFromArray($args);

    if (empty($value)) {
      return null;
    }

    if (is_array($value)) {
      // assuming it's a single dimension
      return array_map(function ($item, $context) {
        return _x($item, $context, 'flynt-theme');
      }, $value, array_keys($value));
    } else {
      $context = array_pop($args);
      return _x($value, $context, 'flynt-theme');
    }
  }

  protected static function cleanConfig($config) {
    $cleanConfig = array_map(function ($value) {
      if (is_array($value)) {
        return self::cleanConfig($value);
      }
      // don't remove boolean values
      return empty($value) && false !== $value ? null : $value;
    }, $config);

    // remove null values or empty arrays
    return array_filter($cleanConfig, function ($value) {
      return !(is_null($value) || (is_array($value) && empty($value)));
    });
  }

  protected static function getConfigs($dir) {
    $configs = FileLoader::iterateDir($dir, function ($file) {
      if ($file->isDir()) {
        $configPath = $file->getPathname() . '/' . self::$fileName;

        if (is_file($configPath)) {
          $dir = $file->getPathname();
          $name = $file->getFilename();
          self::$registeredCustomPostTypes[$name] = [
            'dir' => $dir
          ];
          return array_merge(self::getConfigFromJson($configPath), ['name' => $name]);
        }
      }
      return null;
    });

    return array_filter($configs);
  }

  protected static function getConfigFromJson($filePath) {
    return json_decode(file_get_contents($filePath), true);
  }
}
