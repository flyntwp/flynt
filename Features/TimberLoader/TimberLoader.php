<?php

namespace Flynt\Features;

use Flynt;
use Flynt\Utils\Feature;
use Timber\Timber;
use Timber\Image;
use Twig_SimpleFunction;

class TimberLoader extends Feature {
  public function setup() {
    // Render Component with Timber (Twig)
    add_filter('Flynt/renderComponent', function ($output, $componentName, $componentData, $areaHtml) {
      // get index file
      $componentManager = Flynt\ComponentManager::getInstance();
      $filePath = $componentManager->getComponentFilePath($componentName, 'index.twig');

      if (!is_file($filePath)) {
        trigger_error("Template not found: {$filePath}", E_USER_WARNING);
        return $output;
      }

      $addArea = function ($twig) use ($areaHtml) {

        $twig->addFunction(new Twig_SimpleFunction('area', function ($areaName) use ($areaHtml) {
          if (array_key_exists($areaName, $areaHtml)) {
            return $areaHtml[$areaName];
          }
        }));

        return $twig;

      };

      add_filter('get_twig', $addArea);

      $output = Timber::fetch($filePath, $componentData);

      remove_filter('get_twig', $addArea);

      return $output;
    }, 10, 4);

    // Convert ACF Images to Timber Images
    add_filter('acf/format_value/type=image', function ($value) {
      if (!empty($value)) {
        $value = new Image($value);
      }
      return $value;
    }, 100);
  }
}
