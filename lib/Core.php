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

  public static function loadFiles($dir = '', $files = []) {

    if (count($files) === 0) {
      $directory = get_template_directory() . DIRECTORY_SEPARATOR . $dir;
      $directoryIterator = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);

      foreach ($directoryIterator as $name => $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
          $filePath = $file->getPathname();
          require_once $filePath;
        }
      }
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
