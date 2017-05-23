<?php

namespace Flynt\Features\CustomPostTypes;

use Flynt\Features\CustomPostTypes\Translator;
use Flynt\Utils\StringHelpers;
use Flynt\Utils\FileLoader;

class CustomPostTypeRegister
{

    private static $fileName;
    private static $registeredCustomPostTypes = [];

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
                'Flynt/Features/CustomPostTypes/Register',
                $config['name'],
                self::$registeredCustomPostTypes[$config['name']]
            );
        }
    }

    public static function fromArray($config)
    {
        // clean up invalid and empty values
        $config = self::cleanConfig($config);

        // add string translations
        $config = Translator::translateConfig($config);

        $name = $config['name'];
        unset($config['name']);

        if (!is_wp_error(register_post_type($name, $config))) {
            self::$registeredCustomPostTypes[$name]['config'] = $config;
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
            if ($file->isDir()) {
                $configPath = $file->getPathname() . '/' . self::$fileName;

                if (is_file($configPath)) {
                    $dir = $file->getPathname();
                    $name = StringHelpers::camelCaseToKebap($file->getFilename());
                    self::$registeredCustomPostTypes[$name] = [
                        'dir' => $dir
                    ];
                    $config = self::getConfigFromJson($configPath);
                    if (!empty($config)) {
                        return array_merge($config, ['name' => $name]);
                    }
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
            trigger_error("<strong>[Custom Post Type Register]</strong> Invalid JSON file: {$filePath}", E_USER_WARNING);
            $config = [];
        }

        return $config;
    }

    public static function getAll()
    {
        return self::$registeredCustomPostTypes;
    }
}
