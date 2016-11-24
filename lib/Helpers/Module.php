<?php

namespace WPStarterTheme\Helpers;

use RecursiveDirectoryIterator;
use WPStarter\Defaults;
use WPStarterTheme\Helpers\Utils;

class Module {
  public static function registerAll() {
    $directory = Defaults::getModulesDirectory();

    // TODO use new Core functionality after adding the feature for dirs
    $directoryIterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($directoryIterator as $name => $file) {
      if ($file->isDir()) {
        WPStarter\registerModule($file->getFilename());
      }
    }
  }

  public static function enqueueAssets($moduleName, array $dependencies = []) {
    // register dependencies
    foreach ($dependencies as $dependency) {
      // TODO add some validation
      // TODO consider also using version and in_footer (scripts) / media (styles)
      if ($dependency['type'] === 'script') {
        wp_register_script(
          $dependency['name'],
          Utils::requireAssetUrl($dependency['path']),
          $dependency['dependencies'],
          null, // version
          true // in_footer
        );
      } elseif ($dependency['type'] === 'style') {
        wp_register_style(
          $dependency['name'],
          Utils::requireAssetUrl($dependency['path']),
          $dependency['dependencies'],
          null, // version
          'all' // media
        );
      }
    }

    // TODO move default dependency into some config
    // collect script dependencies
    $scriptDeps = array_reduce($dependencies, function ($list, $dependency) {
      if ($dependency['type'] === 'script') {
        array_push($list, $dependency['name']);
      }
      return $list;
    }, ['jquery']); // jquery as a default dependency

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
    $styleDeps = [];
    if ($moduleName !== 'Layout') {
      $styleDeps = array_reduce($dependencies, function ($list, $dependency) {
        if ($dependency['type'] === 'style') {
          array_push($list, $dependency['name']);
        }
        return $list;
      }, ['WPStarterTheme/Modules/Layout']);
    }

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
