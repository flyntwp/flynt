<?php

namespace Flynt\Features\Components;

require_once __DIR__ . '/Component.php';

use Flynt;
use Flynt\Features\Components\Component;
use Flynt\Utils\FileLoader;
use Flynt\Utils\Feature;

// register all components
$componentPath = trailingslashit(Feature::getOption('flynt-components', 0));

add_action('Flynt/afterRegisterFeatures', function () use ($componentPath) {
    if (is_dir($componentPath)) {
        $components = [];
        FileLoader::iterateDir($componentPath, function ($dir) use (&$components) {
            if ($dir->isDir()) {
                $components[] = $dir->getFilename();
            }
        });
        sort($components, SORT_STRING);
        array_map('Flynt\registerComponent', $components);
    }
});

// set Component Path
add_filter('Flynt/componentPath', function ($defaultPath, $componentName) use ($componentPath) {
    return $componentPath . $componentName;
}, 10, 2);
