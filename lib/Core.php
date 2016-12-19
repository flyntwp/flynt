<?php

namespace Flynt;

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
    // TODO rename folder before going open source
    // (or use class_exists instead if we switch to static Flynt\Flynt class)
    $pluginActive = class_exists('\\Flynt\\Render');

    if (!$pluginActive) {
      add_action('admin_notices', function () {
        echo '<div class="error"><p>Flynt Core Plugin not activated. Make sure you activate the plugin in <a href="'
          . esc_url(admin_url('plugins.php#flynt')) . '">'
          . esc_url(admin_url('plugins.php')) . '</a></p></div>';
      });

      add_filter('template_include', function () {
        $newTemplate = locate_template(array('plugin-inactive.php'));
        if ('' != $newTemplate) {
          return $newTemplate;
        } else {
          return 'Flynt Core Plugin not activated! Please <a href="'
            . esc_url(admin_url('plugins.php'))
            . '">activate the plugin</a> and reload the page.';
        }
      });
    }

    return $pluginActive;

  }

  public static function iterateDirectory($dir, callable $callback) {

    $output = [];

    if (!is_dir($dir)) {
      return $output;
    }

    $directoryIterator = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($directoryIterator as $name => $file) {
      $callbackResult = call_user_func($callback, $file);
      array_push($output, $callbackResult);
    }

    return $output;
  }

  // recursively load all files with a specified extension
  // optionally able to specify the files in an array to load in a certain order
  public static function loadFilesWithExtension(string $fileExtension, $dir = '', $files = []) {

    if (count($files) === 0) {

      $dir = get_template_directory() . '/' . $dir;

      self::iterateDirectory($dir, function ($file) use ($fileExtension) {

        if ($file->isDir()) {

          $dirPath = str_replace(get_template_directory(), '', $file->getPathname());
          self::loadFilesWithExtension($fileExtension, $dirPath, []);

        } elseif ($file->isFile() && $file->getExtension() === $fileExtension) {

          $filePath = $file->getPathname();
          require_once $filePath;

        }

      });

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

  public static function loadPhpFiles($dir = '', $files = []) {
    $fileExtension = 'php';
    self::loadFilesWithExtension('php', $dir, $files);
  }
}
