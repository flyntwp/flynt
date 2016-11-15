<?php

namespace WPStarterTheme\Helpers;

use function WPStarter\registerModule;
use WPStarter\Defaults;
use RecursiveDirectoryIterator;

class Utils {
  public static function OutputBufferContents($func_name, $args = null) {
    ob_start();
    if (isset($args)) {
      $func_name($args);
    } else {
      $func_name();
    }
    $output = ob_get_contents();
    ob_get_clean();
    return $output;
  }

  public static function registerAllModules() {
    $directory = Defaults::getModulesDirectory();
    $Directory = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
    foreach($Directory as $name => $file){
      if ($file->isDir()) {
        registerModule($file->getFilename());
      }
    }
  }
}
