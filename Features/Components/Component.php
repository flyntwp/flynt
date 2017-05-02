<?php

namespace Flynt\Features\Components;

use Flynt\Utils\Asset;
use Flynt\Utils\StringHelpers;

class Component
{
    public static function enqueueAssets($componentName, array $dependencies = [])
    {
        // register dependencies
        foreach ($dependencies as $dependency) {
            // TODO add a warning if the same script is loaded several times (with different names) in multiple components
            Asset::register($dependency);
        }

        // collect script dependencies
        $scriptDeps = array_reduce($dependencies, function ($list, $dependency) {
            if ($dependency['type'] === 'script') {
                array_push($list, $dependency['name']);
            }
            return $list;
        }, ['jquery']); // jquery as a default dependency

        // Enqueue Component Scripts if they exist
        $scriptAbsPath = Asset::requirePath("Components/{$componentName}/script.js");
        if (is_file($scriptAbsPath)) {
            Asset::enqueue([
                'type' => 'script',
                'name' => "Flynt/Components/{$componentName}",
                'path' => "Components/{$componentName}/script.js",
                'dependencies' => $scriptDeps
            ]);
        }

        // collect style dependencies
        $styleDeps = array_reduce($dependencies, function ($list, $dependency) {
            if ($dependency['type'] === 'style') {
                array_push($list, $dependency['name']);
            }
            return $list;
        }, []);

        // Enqueue Component Styles if they exist
        $styleAbsPath = Asset::requirePath("Components/{$componentName}/style.css");
        if (is_file($styleAbsPath)) {
            Asset::enqueue([
                'type' => 'style',
                'name' => "Flynt/Components/{$componentName}",
                'path' => "Components/{$componentName}/style.css",
                'dependencies' => $styleDeps
            ]);
        }
    }
}
