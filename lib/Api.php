<?php

namespace Flynt;

use Flynt\ComponentManager;

/**
 * Provides a set of static methods that can be used to register
 * components and render them.
 */
class Api
{
    /**
     * Register a component.
     *
     * @param string $componentName The name of the component.
     * @param string $componentPath The path to the component.
     */
    public static function registerComponent(string $componentName, ?string $componentPath = null): void
    {
        $componentManager = ComponentManager::getInstance();
        $componentManager->registerComponent($componentName, $componentPath);
    }

    /**
     * Register components from a path.
     *
     * @param string $componentBasePath The path to the components.
     */
    public static function registerComponentsFromPath(string $componentBasePath): void
    {
        foreach (glob("{$componentBasePath}/*", GLOB_ONLYDIR) as $componentPath) {
            $componentName = basename($componentPath);
            self::registerComponent($componentName, $componentPath);
        }
    }

    /**
     * Render a component.
     *
     * @param string $componentName The name of the component.
     * @param array $data The data to pass to the component.
     *
     * @return string The rendered component.
     */
    public static function renderComponent(string $componentName, array $data)
    {
        $data = apply_filters(
            'Flynt/addComponentData',
            $data,
            $componentName
        );

        $output = apply_filters(
            'Flynt/renderComponent',
            null,
            $componentName,
            $data
        );

        return is_null($output) ? '' : $output;
    }

    /**
     * Register hooks.
     */
    public static function registerHooks(): void
    {
        add_filter('Flynt/renderComponent', function ($output, $componentName, $data) {
            return apply_filters(
                "Flynt/renderComponent?name={$componentName}",
                $output,
                $componentName,
                $data
            );
        }, 10, 3);

        add_filter('Flynt/addComponentData', function ($data, $componentName) {
            return apply_filters(
                "Flynt/addComponentData?name={$componentName}",
                $data,
                $componentName
            );
        }, 10, 2);
    }
}
