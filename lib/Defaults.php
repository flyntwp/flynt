<?php

namespace Flynt;

use Flynt\ComponentManager;

class Defaults
{
    public static function init()
    {
        add_filter('Flynt/renderComponent', ['Flynt\Defaults', 'renderComponent'], 999, 3);
        add_action('Flynt/registerComponent', ['Flynt\Defaults', 'loadFunctionsFile']);
    }

    public static function renderComponent($output, $componentName, $componentData)
    {
        if (is_null($output)) {
            $componentManager = ComponentManager::getInstance();
            $filePath = $componentManager->getComponentFilePath($componentName);
            $output = self::renderFile($componentData, $filePath);
        }
        return $output;
    }

    public static function loadFunctionsFile($componentName)
    {
        $componentManager = ComponentManager::getInstance();
        $functionsFilePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $functionsFilePath) {
            require_once $functionsFilePath;
        }
    }

    protected static function renderFile($componentData, $filePath)
    {
        _deprecated_function(__METHOD__, '1.4.0');
        if (!is_file($filePath)) {
            trigger_error("Template not found: {$filePath}", E_USER_WARNING);
            return '';
        }

        ob_start();
        require $filePath;
        $output = ob_get_contents();
        ob_get_clean();

        return $output;
    }
}
