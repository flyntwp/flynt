<?php

namespace Flynt\Utils;

class Component
{
    public static function enqueueAssets($componentName, array $dependencies = [])
    {
        // register dependencies
        foreach ($dependencies as $dependency) {
            // TODO add a warning if the same script is loaded several times (with different names) in multiple components
            if ($dependency['type'] === 'style') {
                Asset::enqueue($dependency);
            } else {
                Asset::register($dependency);
            }
        }

        // collect script dependencies
        $scriptDeps = array_reduce($dependencies, function ($list, $dependency) {
            if ($dependency['type'] === 'script') {
                array_push($list, $dependency['name']);
            }
            return $list;
        }, []); // jquery as a default dependency

        if (!empty($scriptDeps)) {
            Asset::addDependencies('Flynt/assets', $scriptDeps);
        }

        // collect style dependencies
        // $styleDeps = array_reduce($dependencies, function ($list, $dependency) {
        //     if ($dependency['type'] === 'style') {
        //         array_push($list, $dependency['name']);
        //     }
        //     return $list;
        // }, []);

        // if (!empty($scriptDeps)) {
        //     Asset::addDependencies('Flynt/assets', $styleDeps, 'styles');
        // }

        // Enqueue Component Styles if they exist
        // $styleAbsPath = Asset::requirePath("Components/{$componentName}/style.css");
        // if (is_file($styleAbsPath)) {
        //     Asset::enqueue([
        //         'type' => 'style',
        //         'name' => "Flynt/Components/{$componentName}",
        //         'path' => "Components/{$componentName}/style.css",
        //         'dependencies' => $styleDeps
        //     ]);
        // }
    }
}
