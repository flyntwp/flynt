<?php

namespace Flynt\Utils;

class Asset
{
    const DEFAULT_OPTIONS = [
        'dependencies' => [],
        'version' => null,
        'inFooter' => true,
        'media' => 'all'
    ];

    protected static $assetManifest;

    public static function requireUrl($asset)
    {
        return self::get('url', $asset);
    }

    public static function requirePath($asset)
    {
        return self::get('path', $asset);
    }

    public static function register($options)
    {
        return self::add('register', $options);
    }

    public static function enqueue($options)
    {
        return self::add('enqueue', $options);
    }

    protected static function get($returnType, $asset)
    {
        $distPath = get_template_directory() . '/dist';

        if (!isset(self::$assetManifest)) {
            $manifestPath = $distPath . '/rev-manifest.json';
            if (is_file($manifestPath)) {
                self::$assetManifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                self::$assetManifest = [];
            }
        }

        if (array_key_exists($asset, self::$assetManifest)) {
            $assetSuffix = self::$assetManifest[$asset];
        } else {
            $assetSuffix = $asset;
        }

        if ('path' == $returnType) {
            return $distPath . '/' . $assetSuffix;
        } else if ('url' == $returnType) {
            $distUrl = get_template_directory_uri() . '/dist';
            return $distUrl . '/' . $assetSuffix;
        }

        return false;
    }

    protected static function add($funcType, $options)
    {
        // TODO add cdn functionality
        $options = array_merge(self::DEFAULT_OPTIONS, $options);

        if (!array_key_exists('name', $options)) {
            trigger_error('Cannot add asset: Name not provided!', E_USER_WARNING);
            return false;
        }

        if (!array_key_exists('path', $options)) {
            trigger_error('Cannot add asset: Path not provided!', E_USER_WARNING);
            return false;
        }

        $funcName = "wp_{$funcType}_{$options['type']}";
        $lastVar = $options['type'] === 'script' ? $options['inFooter'] : $options['media'];

        // allow external urls
        $path = $options['path'];
        if (!(StringHelpers::startsWith('http://', $path))
            && !(StringHelpers::startsWith('https://', $path))
            && !(StringHelpers::startsWith('//', $path))
        ) {
            $path = Asset::requireUrl($options['path']);
        }

        if (function_exists($funcName)) {
            $funcName(
                $options['name'],
                $path,
                $options['dependencies'],
                $options['version'],
                $lastVar
            );

            return true;
        }

        return false;
    }
}
