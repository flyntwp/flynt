<?php

namespace WPStarterTheme;

use RecursiveDirectoryIterator;

class Core {
  public static function loadFiles($dir = '', $files = []) {
    if(count($files) === 0) {
      $directory = get_template_directory() . DIRECTORY_SEPARATOR . $dir;
      $Directory = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
      foreach($Directory as $name => $file){
        if($file->isFile() && $file->getExtension() === 'php') {
          $filePath = $file->getPathname();
          require_once $filePath;
        }
      }
    } else {
      array_walk($files, function ($file) use ($dir) {
        $filePath = $dir . $file;
        if (!locate_template($filePath, true, true)) {
          trigger_error(sprintf(__('Error locating %s for inclusion', 'wp-starter-boilerplate'), $filePath), E_USER_ERROR);
        }
      });
    }
  }
}
