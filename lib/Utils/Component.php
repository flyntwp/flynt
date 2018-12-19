<?php

namespace Flynt\Utils;

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
        }, []); // jquery as a default dependency

        // collect style dependencies
        $styleDeps = array_reduce($dependencies, function ($list, $dependency) {
            if ($dependency['type'] === 'style') {
                array_push($list, $dependency['name']);
            }
            return $list;
        }, []);

        if (!empty($scriptDeps) || !empty($styleDeps)) {
            add_action('wp_enqueue_scripts', function () use ($scriptDeps, $styleDeps) {
                Asset::addDependencies('Flynt/assets', $scriptDeps);
                Asset::addDependencies('Flynt/assets', $styleDeps, 'style');
            }, 11);
        }
    }
}
