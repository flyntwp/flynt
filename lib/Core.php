<?php

namespace WPStarterTheme;

use RecursiveDirectoryIterator;

class Core {
  public static function checkPlugin() {
    // TODO check if this is a problem
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $pluginActive = is_plugin_active('wp-starter-plugin/wp-starter-plugin.php');

    // TODO or use this instead?
    // $pluginActive = class_exists('WPStarter\Defaults');

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
