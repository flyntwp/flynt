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
        add_filter('Flynt/configPath', ['Flynt\Defaults', 'setConfigPath'], 999, 2);
        add_filter('Flynt/configFileLoader', ['Flynt\Defaults', 'loadConfigFile'], 999, 3);
        add_filter('Flynt/renderComponent', ['Flynt\Defaults', 'renderComponent'], 999, 4);
        add_filter('Flynt/componentPath', ['Flynt\Defaults', 'setComponentPath'], 999, 2);
        add_action('Flynt/registerComponent', ['Flynt\Defaults', 'loadFunctionsFile']);
    }

    public static function setConfigPath($configPath, $configFileName)
    {
        if (is_null($configPath)) {
            $configPath = get_template_directory() . '/' . self::CONFIG_DIR . '/' . $configFileName;
        }
        return $configPath;
    }

    public static function loadConfigFile($config, $configName, $configPath)
    {
        if (is_null($config)) {
            $config = json_decode(file_get_contents($configPath), true);
        }
        return $config;
    }

    public static function renderComponent($output, $componentName, $componentData, $areaHtml)
    {
        if (is_null($output)) {
            $componentManager = ComponentManager::getInstance();
            $filePath = $componentManager->getComponentFilePath($componentName);
            $output = self::renderFile($componentData, $areaHtml, $filePath);
        }
        return $output;
    }

    public static function setComponentPath($componentPath, $componentName)
    {
        if (is_null($componentPath)) {
            $componentPath = self::getComponentsDirectory() . '/' . $componentName;
        }
        return $componentPath;
    }

    public static function getComponentsDirectory()
    {
        return get_template_directory() . '/' . self::COMPONENT_DIR;
    }

  // this action needs to be removed by the user if they want to overwrite this functionality
    public static function loadFunctionsFile($componentName)
    {
        $componentManager = ComponentManager::getInstance();
        $filePath = $componentManager->getComponentFilePath($componentName, 'functions.php');
        if (false !== $filePath) {
            require_once $filePath;
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
