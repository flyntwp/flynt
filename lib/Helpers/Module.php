<?php

namespace WPStarterTheme\Helpers;

use RecursiveDirectoryIterator;
use WPStarter;
use WPStarterTheme\Config;
use WPStarterTheme\Helpers\Utils;

class Module {
  public static function registerAll() {
    // TODO use new Core functionality after adding the feature for dirs
    $directoryIterator = new RecursiveDirectoryIterator(Config\MODULE_PATH, RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($directoryIterator as $name => $file) {
      if ($file->isDir()) {
        WPStarter\registerModule($file->getFilename());
      }
    }
  }

  public static function enqueueAssets($moduleName, array $dependencies = []) {
    $dependencyDefaults = [
      'dependencies' => [],
      'version' => null,
      'inFooter' => true,
      'media' => 'all'
    ];

    // register dependencies
    foreach ($dependencies as $dependency) {
      // TODO add cdn functionality
      // TODO add a warning if the same script is loaded several times (with different names) in multiple modules
      $dependency = array_merge($dependencyDefaults, $dependency);

      if (!array_key_exists('name', $dependency)) {
        trigger_error('Cannot load dependency: Name not provided!', E_USER_WARNING);
        continue;
      }

      if (!array_key_exists('path', $dependency)) {
        trigger_error('Cannot load dependency: Path not provided!', E_USER_WARNING);
        continue;
      }

      if ($dependency['type'] === 'script') {
        wp_register_script(
          $dependency['name'],
          Utils::requireAssetUrl($dependency['path']),
          $dependency['dependencies'],
          $dependency['version'],
          $dependency['inFooter']
        );
      } elseif ($dependency['type'] === 'style') {
        wp_register_style(
          $dependency['name'],
          Utils::requireAssetUrl($dependency['path']),
          $dependency['dependencies'],
          $dependency['version'],
          $dependency['media']
        );
      }
    }

    // collect script dependencies
    $scriptDeps = array_reduce($dependencies, function ($list, $dependency) {
      if ($dependency['type'] === 'script') {
        array_push($list, $dependency['name']);
      }
      return $list;
    }, ['Modules/scripts']); // jquery as a default dependency

    // Enqueue Module Scripts if they exist
    $scriptAbsPath = Utils::requireAssetPath("Modules/{$moduleName}/script.js");
    if (is_file($scriptAbsPath)) {
      wp_enqueue_script(
        "WPStarterTheme/Modules/{$moduleName}",
        Utils::requireAssetUrl("Modules/{$moduleName}/script.js"),
        $scriptDeps,
        null
      );
    }

    // collect style dependencies
    $styleDeps = array_reduce($dependencies, function ($list, $dependency) {
      if ($dependency['type'] === 'style') {
        array_push($list, $dependency['name']);
      }
      return $list;
    }, []);

    // Enqueue Module Styles if they exist
    $styleAbsPath = Utils::requireAssetPath("Modules/{$moduleName}/style.css");
    if (is_file($styleAbsPath)) {
      wp_enqueue_style(
        "WPStarterTheme/Modules/{$moduleName}",
        Utils::requireAssetUrl("Modules/{$moduleName}/style.css"),
        $styleDeps,
        null
      );
    }
  }
}
