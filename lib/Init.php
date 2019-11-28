<?php

namespace Flynt;

use Flynt\Api;
use Flynt\Defaults;
use Flynt\Utils\AdminNoticeManager;
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
        $basePath = get_template_directory() . '/Components';
        Api::registerComponentsFromPath($basePath);
        do_action('Flynt/afterRegisterComponents');
    }

    public static function checkRequiredPlugins()
    {
        $acfActive = class_exists('acf');

        if (!$acfActive) {
            self::notifyRequiredPluginIsMissing('<a href="https://www.advancedcustomfields.com/pro/">Advanced Custom Fields PRO</a>');
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
        $manager = AdminNoticeManager::getInstance();

        $pluginUrl = esc_url(admin_url('plugins.php'));
        $message = ["${pluginName} plugin not activated. Make sure you activate the plugin on the <a href=\"${pluginUrl}\">plugin page</a>."];
        $options = [
          'type' => 'error',
          'title' => 'Flynt is missing a required plugin',
          'dismissible' => false,
        ];

        $manager->addNotice($message, $options);
    }
}
