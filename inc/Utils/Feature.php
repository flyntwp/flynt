<?php

namespace Flynt\Utils;

class Feature
{

    private static $initialFile = 'functions.php';
    private static $features = [];

    /**
     * Gets all options for a feature.
     *
     * Returns all parameters passed to `add_theme_support` in the lib/Init.php file.
     *
     * @since 0.1.0
     *
     * @param string $feature Name of the feature.
     *
     * @return array|null Returns an array of options or null if the feature wasn't found.
     */
    public static function getOptions($feature)
    {
        $feature = self::getFeature($feature);
        return $feature ? $feature['options'] : null;
    }

    /**
     * Gets single option for a feature.
     *
     * Returns a single parameter passed to `add_theme_support` in the lib/Init.php file using the key (starting with 0) of that option.
     *
     * @since 0.1.0
     *
     * @param string $feature Name of the feature.
     * @param string $key The option key.
     *
     * @return mixed|null Returns the option or null if the option / the feature doesn't exist.
     */
    public static function getOption($feature, $key)
    {
        $options = self::getOptions($feature);
        return is_array($options) && array_key_exists($key, $options) ? $options[$key] : null;
    }

    /**
     * Gets the absolute path of a feature.
     *
     * @since 0.1.0
     *
     * @param string $feature Name of the feature.
     *
     * @return string|null Returns the path or null if the feature doesn't exist.
     */
    public static function getDir($feature)
    {
        $feature = self::getFeature($feature);
        return $feature ? $feature['dir'] : null;
    }

    /**
     * Registers a feature.
     *
     * @since 0.1.0
     *
     * @param string $feature Name of the feature.
     * @param string $basePath The feature base path.
     * @param array $options An array of options. Optional.
     *
     * @return boolean
     */
    public static function register($feature, $basePath, $options = [])
    {
        if (!isset(self::$features[$feature])) {
            $prettyName = StringHelpers::removePrefix('flynt', StringHelpers::kebapCaseToCamelCase($feature));
            $dir = implode('/', [$basePath, $prettyName]);
            $file = implode('/', [$dir, self::$initialFile]);
            $fieldsFile = implode('/', [$dir, 'fields.php']);

            if (is_file($file)) {
                $options = (array) $options;

                self::$features[$feature] = [
                'options' => $options,
                'dir' => $dir,
                'name' => $prettyName
                ];

                if (is_file($fieldsFile)) {
                    global $flyntCurrentOptionCategory;
                    $flyntCurrentOptionCategory = 'feature';
                    require_once $fieldsFile;
                }

                require_once $file;

                // execute post register actions
                do_action('Flynt/registerFeature', $prettyName, $options, $dir);
                do_action("Flynt/registerFeature?name={$prettyName}", $prettyName, $options, $dir);

                return true;
            }

            trigger_error("{$feature}: Could not register feature! File not found: {$file}", E_USER_WARNING);

            return false;
        }
    }

    /**
     * Checks if a feature is already registered.
     *
     * @since 0.1.0
     *
     * @param string $name The feature name.
     *
     * @return boolean
     */
    public static function isRegistered($name)
    {
        return array_key_exists($name, self::$features);
    }

    /**
     * Gets a registered feature.
     *
     * @since 0.1.0
     *
     * @param string $name Name of the feature.
     *
     * @return array|boolean Returns an array with feature options and its directory or false if the feature is not registered.
     */
    public static function getFeature($name)
    {
        if (isset(self::$features[$name])) {
            return self::$features[$name];
        }
        return false;
    }

    /**
     * Gets all registered features.
     *
     * @since 0.1.0
     *
     * @return array Array of features with their options and directory.
     */
    public static function getFeatures()
    {
        return self::$features;
    }

    /**
     * Sets the initial file to be required for a feature.
     *
     * @since 0.1.0
     *
     * @param string $fileName File name or path relative to a feature's directory.
     */
    public static function setInitialFile($fileName)
    {
        self::$initialFile = $fileName;
    }
}
