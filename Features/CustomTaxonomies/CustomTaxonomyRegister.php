<?php

namespace Flynt\Features\CustomTaxonomies;

use Flynt\Features\CustomTaxonomies\Translator;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

class CustomTaxonomyRegister
{

    private static $fileName;
    private static $registeredCustomTaxonomies = [];

    public static function fromDir($dir, $fileName)
    {
        self::$fileName = $fileName;

        $postTypesConfig = self::getConfigs($dir);

        if (empty($postTypesConfig)) {
            return;
        }

        foreach ($postTypesConfig as $config) {
            self::fromArray($config);

            do_action(
                'Flynt/Features/CustomTaxonomies/Register',
                $config['name'],
                self::$registeredCustomTaxonomies[$config['name']]
            );
        }
    }

    public static function fromArray($config)
    {
        if (empty($config['objectType'])) {
            trigger_error("<strong>[Custom Taxonomy Register]</strong> Object Type not provided for {$config['name']}", E_USER_WARNING);
            return;
        }

        // clean up invalid and empty values
        $config = self::cleanConfig($config);

        // add string translations
        $config = Translator::translateConfig($config);

        $name = $config['name'];
        $objectType = $config['objectType'];
        unset($config['name']);
        unset($config['objectType']);

        if (!is_wp_error(register_taxonomy($name, $objectType, $config))) {
            self::$registeredCustomTaxonomies[$name]['config'] = $config;
        }
    }

    protected static function cleanConfig($config)
    {
        $cleanConfig = array_map(function ($value) {
            if (is_array($value)) {
                return self::cleanConfig($value);
            }
            // don't remove boolean values
            return empty($value) && false !== $value ? null : $value;
        }, $config);

        // remove null values or empty arrays
        return array_filter($cleanConfig, function ($value) {
            return !(is_null($value) || (is_array($value) && empty($value)));
        });
    }

    protected static function getConfigs($dir)
    {
        $configs = FileLoader::iterateDir($dir, function ($file) {
            if ($file->isFile() && $file->getExtension() == 'json') {
                $configPath = $file->getPathname();
                $name = StringHelpers::camelCaseToKebap($file->getBasename('.json'));
                self::$registeredCustomTaxonomies[$name] = [
                    'configPath' => $configPath
                ];
                $config = self::getConfigFromJson($configPath);
                if (!empty($config)) {
                    return array_merge($config, ['name' => $name]);
                }
            }
            return null;
        });

        return array_filter($configs);
    }

    protected static function getConfigFromJson($filePath)
    {
        $config = json_decode(file_get_contents($filePath), true);

        if (null === $config) {
            trigger_error("<strong>[Custom Taxonomy Register]</strong> Invalid JSON file: {$filePath}", E_USER_WARNING);
            $config = [];
        }

        return $config;
    }

    public static function getAll()
    {
        return self::$registeredCustomTaxonomies;
    }
}
