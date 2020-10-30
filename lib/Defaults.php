<?php

namespace Flynt;

use Flynt\ComponentManager;

class Defaults
{
    public static function init()
    {
        add_action('Flynt/registerComponent', ['Flynt\Defaults', 'loadFunctionsFile']);
    }

    public static function loadFunctionsFile($componentName)
    {
        $componentManager = ComponentManager::getInstance();
        $functionsFilePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $functionsFilePath) {
            require_once $functionsFilePath;
        }
    }
}
