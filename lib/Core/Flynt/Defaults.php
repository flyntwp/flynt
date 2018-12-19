<?php

namespace Flynt;

use Flynt\ComponentManager;
use Flynt\Helpers;

class Defaults
{
    const CONFIG_DIR = 'config';
    const COMPONENT_DIR = 'Components';

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
            $output = self::renderFile($componentData, $areaHtml, $filePath);
        }
        return $output;
    }

  // this action needs to be removed by the user if they want to overwrite this functionality
    public static function loadFunctionsFile($componentName)
    {
        $componentManager = ComponentManager::getInstance();
        $functionsFilePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $functionsFilePath) {
            require_once $functionsFilePath;
        }
    }

    protected static function renderFile($componentData, $areaHtml, $filePath)
    {
        if (!is_file($filePath)) {
            trigger_error("Template not found: {$filePath}", E_USER_WARNING);
            return '';
        }

        $area = function ($areaName) use ($areaHtml) {
            if (array_key_exists($areaName, $areaHtml)) {
                return $areaHtml[$areaName];
            }
        };

        $data = function () use ($componentData) {
            $args = func_get_args();
            array_unshift($args, $componentData);
            return Helpers::extractNestedDataFromArray($args);
        };

        ob_start();
        require $filePath;
        $output = ob_get_contents();
        ob_get_clean();

        return $output;
    }
}
