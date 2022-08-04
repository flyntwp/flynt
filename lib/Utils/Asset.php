<?php

namespace Flynt\Utils;

class Asset
{
    protected static $assetManifest;

    /**
     * Gets the asset's url.
     *
     * @since 0.1.0
     *
     * @param string $asset The filename of the required asset.
     *
     * @return string|boolean Returns the url or false if the asset is not found.
     */
    public static function requireUrl($asset)
    {
        return self::get('url', $asset);
    }

    /**
     * Gets the asset's absolute path.
     *
     * @since 0.1.0
     *
     * @param string $asset The filename of the required asset.
     *
     * @return string|boolean Returns the absolute path or false if the asset is not found.
     */
    public static function requirePath($asset)
    {
        return self::get('path', $asset);
    }

    /**
     * Gets the contents of an asset.
     *
     * Useful for loading SVGs or other files inline.
     *
     * @since 0.2.0
     *
     * @param string $asset Asset path (relative to the theme directory).
     * @return string|boolean Returns the file contents or false in case of failure.
     */
    public static function getContents($asset)
    {
        $file = self::requirePath($asset);
        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            trigger_error("File not found at: ${asset}", E_USER_WARNING);
            return false;
        }
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

        if (file_exists($distPath . '/' . $assetSuffix)) {
            if ('path' == $returnType) {
                return $distPath . '/' . $assetSuffix;
            } else if ('url' == $returnType) {
                $distUrl = get_template_directory_uri() . '/dist';
                return $distUrl . '/' . $assetSuffix;
            }
        } else {
            if ('path' == $returnType) {
                return get_template_directory() . '/' . $assetSuffix;
            } else if ('url' == $returnType) {
                return get_template_directory_uri() . '/' . $assetSuffix;
            }
        }

        return false;
    }
}
