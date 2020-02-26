<?php

namespace Flynt\Utils;

// TODO: add async & defer (see https://matthewhorne.me/defer-async-wordpress-scripts/); also add to cdn fallback

class Asset
{
    const DEFAULT_OPTIONS = [
        'dependencies' => [],
        'version' => null,
        'inFooter' => true,
        'media' => 'all',
        'cdn' => []
    ];

    protected static $assetManifest;
    protected static $loadFromCdn = false;

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
     * Registers an asset.
     * It can register a script or a style.
     *
     * If the Asset utility has `loadFromCdn` set to true, you can use the cdn option to load an asset from the CDN,
     * the path option will then become the local fallback file, using the 'check' in the 'cdn' array.
     *
     * @since 0.1.0
     * @since 0.2.0 Supports CDN parameter.
     *
     * @param array $options Options must specify a type, a name and a path.
     *              $options = [
     *                 'type'          => (string) The type of asset to register (script|style).
     *                 'name'          => (string) Should be unique as it is used to identify the script in the whole system.
     *                 'path'          => (string) The path.
     *                 'dependencies'  => (array) An array of registered script handles this script depends on.
     *                 'version'       => (string/boolean) String specifying script version number, if it has one.
     *                 'inFooter'      => (boolean) If the type is 'script', whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
     *                 'media'         => (string) If the type is 'style', string specifying the media for which this stylesheet has been defined (all/screen/handheld/print).
     *                 'cdn'           => [
     *                      'url'   => (string) The CDN url.
     *                      'check' => (string/boolean) Javascript boolean value that loads the local fallback if it is false.
     *                 ]
     *              ]
     *
     * @return boolean
     */
    public static function register($options)
    {
        return self::add('register', $options);
    }

    /**
     * Enqueues an asset.
     * It can enqueue a script or a style.
     *
     * @since 0.1.0
     * @since 0.2.0 Supports CDN parameter.
     *
     * @param array $options Options must specify a type, a name and a path.
     *              $options = [
     *                 'type'          => (string) The type of asset to register (script|style).
     *                 'name'          => (string) Should be unique as it is used to identify the script in the whole system.
     *                 'path'          => (string) The path.
     *                 'dependencies'  => (array) An array of registered script handles this script depends on.
     *                 'version'       => (string/boolean) String specifying script version number, if it has one.
     *                 'inFooter'      => (boolean) If the type is 'script', whether to enqueue the script before </body> instead of in the <head>. Default 'false'.
     *                 'media'         => (string) If the type is 'style', string specifying the media for which this stylesheet has been defined (all/screen/handheld/print).
     *                 'cdn'           => [
     *                      'url'   => (string) The CDN url.
     *                      'check' => (string/boolean) Javascript boolean value that loads the local fallback if it is false.
     *                 ]
     *              ]
     *
     * @return boolean
     */
    public static function enqueue($options)
    {
        return self::add('enqueue', $options);
    }

    /**
     * Getter and setter for the loadFromCdn setting.
     *
     * @param boolean $load (optional) Value to set the parameter to.
     *
     * @since 0.2.0
     */
    public static function loadFromCdn($load = null)
    {
        if (!isset($load)) {
            return self::$loadFromCdn;
        }
        self::$loadFromCdn = (bool) $load;
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

    public static function addDependencies($handle, $dependencies, $type = null)
    {
        if (empty($dependencies)) {
            return;
        }
        if ($type === 'style') {
            global $wp_styles;
            $repo =& $wp_styles;
        } else {
            global $wp_scripts;
            $repo =& $wp_scripts;
        }

        $asset = $repo->query($handle, 'registered');
        if (!$asset) {
            return false;
        }
        $asset->deps = array_unique(array_merge($asset->deps, $dependencies));
        return true;
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
        } elseif ('url' == $returnType) {
            $distUrl = get_template_directory_uri() . '/dist';
            return $distUrl . '/' . $assetSuffix;
        }

        return false;
    }

    protected static function add($funcType, $options)
    {
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
        if (
            !(StringHelpers::startsWith('http://', $path))
            && !(StringHelpers::startsWith('https://', $path))
            && !(StringHelpers::startsWith('//', $path))
        ) {
            $fileExists = file_exists(self::requirePath($path));
            $path = Asset::requireUrl($path);
        } else {
            $fileExists = true;
        }

        if (
            'script' === $options['type']
            && true === self::$loadFromCdn
            && !empty($options['cdn'])
            && !empty($options['cdn']['check'])
            && !empty($options['cdn']['url'])
        ) {
            // if the script isn't registered or enqueued yet
            if (
                !wp_script_is($options['name'], 'registered')
                && !wp_script_is($options['name'], 'enqueued')
            ) {
                $localPath = $path;
                $path = $options['cdn']['url'];
            } else {
                // script already registered / enqueued
                // get registered script and compare paths
                $scriptPath = wp_scripts()->registered[$options['name']]->src;

                // deregister script and set cdn options to re-register down below
                if ($options['cdn']['url'] !== $scriptPath) {
                    wp_deregister_script($options['name']);
                    $localPath = $path;
                    $path = $options['cdn']['url'];
                }
            }
        }

        if (function_exists($funcName) && $fileExists) {
            $funcName(
                $options['name'],
                $path,
                $options['dependencies'],
                $options['version'],
                $lastVar
            );

            if (isset($localPath)) {
                $cdnCheck = $options['cdn']['check'];
                wp_add_inline_script(
                    $options['name'],
                    "${cdnCheck}||document.write(\"<script src=\\\"${localPath}\\\"><\/script>\")"
                );
            }

            return true;
        }

        return false;
    }
}
