<?php

namespace Flynt;

use Flynt\Api;
use Flynt\Defaults;
use Flynt\Utils\Asset;
use Timber\Timber;

class Init
{
    public static function initTheme()
    {
        Api::registerHooks();
        Defaults::init();

        // Set to true to load all assets from a CDN if there is one specified
        Asset::loadFromCdn(false);

        new Timber();
    }

    public static function loadComponents()
    {
        $basePath = get_template_directory() . '/dist/Components';
        global $flyntCurrentOptionCategory;
        $flyntCurrentOptionCategory = 'component';
        Api::registerComponentsFromPath($basePath);
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
        $acfActive = class_exists('acf');

        if (!$acfActive) {
            self::notifyRequiredPluginIsMissing('ACF');
        }

        if (!$acfActive) {
            add_filter('template_include', function () {
                die(
                    'One or more required plugins are not activated! Please <a href="'
                    . esc_url(admin_url('plugins.php'))
                    . '">activate or install the required plugin(s)</a> and reload the page.'
                );
            });
        }

        return $acfActive;
    }

    protected static function notifyRequiredPluginIsMissing($pluginName)
    {
        add_action('admin_notices', function () use ($pluginName) {
            echo "<div class=\"error\"><p>${pluginName} Plugin not activated. Make sure you activate the plugin on the <a href=\""
                . esc_url(admin_url('plugins.php')) . "\">plugin page</a>.</p></div>";
        });
    }
}
