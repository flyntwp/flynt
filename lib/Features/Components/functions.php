<?php

require_once __DIR__ . '/Component.php';

// TODO rename this, makes little sense (also used in components themselves, so be careful!)
use Flynt\Features\Components\Component;

// TODO move this somewhere else
add_filter('Flynt/componentPath', function ($componentPath, $componentName) {
  return get_template_directory() . '/dist/Components/' . $componentName;
}, 10, 2);

Component::registerAll();
