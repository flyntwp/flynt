<?php

namespace Flynt;

use Flynt;
use Flynt\Utils\Asset;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;
use Timber\Timber;

class Init
{
    public static function initTheme()
    {
        // initialize plugin defaults
        Flynt\initDefaults();

        // Set to true to load all assets from a CDN if there is one specified
        Asset::loadFromCdn(false);

        new Timber();
    }

    public static function loadFeatures()
    {
        $basePath = get_template_directory() . '/dist/Features';
        global $flyntCurrentOptionCategory;
        $flyntCurrentOptionCategory = 'feature';
        Flynt\registerFeaturesFromPath($basePath);
        do_action('Flynt/afterRegisterFeatures');
    }

    public static function loadComponents()
    {
        $basePath = get_template_directory() . '/dist/Components';
        global $flyntCurrentOptionCategory;
        $flyntCurrentOptionCategory = 'component';
        Flynt\registerComponentsFromPath($basePath);
        do_action('Flynt/afterRegisterComponents');
    }

    public static function setTemplateDirectory()
    {
        add_action('after_switch_theme', function () {
            $stylesheet = get_option('stylesheet');

            if (basename($stylesheet) !== 'templates') {
                update_option('stylesheet', $stylesheet . '/templates');
            }
        });

        add_filter('stylesheet', function ($stylesheet) {
            return dirname($stylesheet);
        });
    }

    public static function checkRequiredPlugins()
    {
        $flyntCoreActive = function_exists('\\Flynt\\renderComponent');
        $acfActive = class_exists('acf');

        if (!$flyntCoreActive) {
            self::notifyRequiredPluginIsMissing('Flynt Core');
        }

        if (!$acfActive) {
            self::notifyRequiredPluginIsMissing('ACF');
        }

        if (!$acfActive || !$flyntCoreActive) {
            add_filter('template_include', function () {
                die(
                    'One or more required plugins are not activated! Please <a href="'
                    . esc_url(admin_url('plugins.php'))
                    . '">activate or install the required plugin(s)</a> and reload the page.'
                );
            });
        }

        return $acfActive && $flyntCoreActive;
    }

    protected static function notifyRequiredPluginIsMissing($pluginName)
    {
        add_action('admin_notices', function () use ($pluginName) {
            echo "<div class=\"error\"><p>${pluginName} Plugin not activated. Make sure you activate the plugin on the <a href=\""
                . esc_url(admin_url('plugins.php')) . "\">plugin page</a>.</p></div>";
        });
    }
}
