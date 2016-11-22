<?php

namespace WPStarterTheme;

use RecursiveDirectoryIterator;

class Core {

  public static function setTemplateDirectory() {

    add_action('after_switch_theme', function () {
      $stylesheet = get_option('stylesheet');

      if (basename($stylesheet) !== 'templates') {
        update_option('stylesheet', $stylesheet . '/templates');
      }
    });

    add_filter('stylesheet', function ($stylesheet) {
      return dirname($stylesheet);
    });

  }

  public static function checkPlugin() {

    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $pluginActive = is_plugin_active('wp-starter-plugin/wp-starter-plugin.php');

    if (!$pluginActive) {
      add_filter('template_include', function () {
        $newTemplate = locate_template(array('plugin-inactive.php'));
        if ('' != $newTemplate) {
          return $newTemplate;
        } else {
          return 'WP Starter Plugin not activated! Please activate the plugin and reload the page.';
        }
      });
    }

    return $pluginActive;

  }

  public static function iterateDirectory($dir, callable $callback, $fileExtension = null) {

    $directoryIterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);

    $output = [];

    foreach ($directoryIterator as $name => $file) {
      if (!is_null($fileExtension)) {
        $filecheck = $file->isFile() && $file->getExtension() === $fileExtension;
      } else {
        $filecheck = $file->isFile();
      }

      if ($filecheck) {
        $callbackResult = call_user_func($callback, $file);
        array_push($output, $callbackResult);
      }
    }

    return $output;
  }

  public static function loadPhpFiles($dir = '', $files = []) {

    $fileExtension = 'php';

    if (count($files) === 0) {
      $dir = get_template_directory() . '/' . $dir;
      self::iterateDirectory($dir, function ($file) {
        $filePath = $file->getPathname();
        require_once $filePath;
      }, $fileExtension);
    } else {
      array_walk($files, function ($file) use ($dir) {
        $filePath = $dir . $file;

        if (!locate_template($filePath, true, true)) {
          trigger_error(
            sprintf(__('Error locating %s for inclusion', 'wp-starter-boilerplate'), $filePath),
            E_USER_ERROR
          );
        }
      });
    }
  }
}
