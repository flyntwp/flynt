<?php

namespace Flynt\Features;

require_once __DIR__ . '/Component.php';

// TODO rename "Component" class, makes little sense (also used in components themselves, so be careful!)
use Flynt;
use Flynt\Features\Components\Component;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;

class Components extends Feature {

  const COMPONENT_PATH = '/dist/Components/';

  public function setup() {
    // set Component Path
    add_filter('Flynt/componentPath', function ($componentPath, $componentName) {
      return get_template_directory() . '/dist/Components/' . $componentName;
    }, 10, 2);
  }

  public function init() {
    // register all components
    FileLoader::iterateDir(get_template_directory() . self::COMPONENT_PATH, function ($dir) {
      if ($dir->isDir()) {
        Flynt\registerComponent($dir->getFilename());
      }
    });
  }
}
