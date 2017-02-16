<?php

namespace Flynt\Features\TimberLoader;

use Flynt;
use Timber\Timber;
use Timber\Image;
use Twig_SimpleFunction;

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

// Convert ACF Field of type post_object to a Timber\Post and add all ACF Fields of that Post
add_filter('acf/format_value/type=post_object', function ($value) {
  if (!empty($value)) {
    if(is_object($value) && get_class($value) === 'WP_Post') {
      $value = new Post($value);
      $value->fields = get_fields($value->ID);
    }
  }
  return $value;
}, 100);
