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
     *
     * @return void
     */
    public static function init()
    {
        add_action('Flynt/registerComponent', ['Flynt\Defaults', 'loadFunctionsFile']);
    }

    /**
     * Load the functions.php file of a component.
     *
     * @param string $componentName The name of the component.
     *
     * @return void
     */
    public static function loadFunctionsFile(string $componentName)
    {
        $componentManager = ComponentManager::getInstance();
        $functionsFilePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $functionsFilePath) {
            require_once $functionsFilePath;
        }
    }
}
