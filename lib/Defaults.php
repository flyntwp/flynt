<?php

namespace Flynt;

use Flynt\ComponentManager;

/**
 * Provides a set of static methods that are used to load the
 * functions.php file of a component.
 */
class Defaults
{
    /**
     * Initialize the class.
     */
    public static function init(): void
    {
        add_action('Flynt/registerComponent', [self::class, 'loadFunctionsFile']);
    }

    /**
     * Load the functions.php file of a component.
     *
     * @param string $componentName The name of the component.
     */
    public static function loadFunctionsFile(string $componentName): void
    {
        $componentManager = ComponentManager::getInstance();
        $functionsFilePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $functionsFilePath) {
            require_once $functionsFilePath;
        }
    }
}
