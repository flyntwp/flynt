<?php

namespace Flynt\Features\Acf;

use Flynt\Features\AdminNotices\AdminNoticeManager;
use Flynt\Features\Components\Component;
use Flynt\Utils\ArrayHelpers;

class Loader
{

    protected static $helpers = [];
    protected static $requirements = [];
    protected static $requirementsMet = false;

    public static function setup($helpers)
    {
        if (empty($helpers)) {
            return;
        }

        self::$helpers = ArrayHelpers::indexedValuesToAssocKeys($helpers);
        self::$requirementsMet = !in_array(false, self::checkRequirements(), true);

        if (self::$requirementsMet) {
            self::setupHelpers();

            // add styles for admin area
            add_action('admin_enqueue_scripts', function () {
                Component::addAsset('enqueue', [
                'type' => 'style',
                'name' => 'Flynt/Features/Acf/AdminCss',
                'path' => 'Features/Acf/admin.css'
                ]);

                Component::addAsset('enqueue', [
                'type' => 'script',
                'name' => 'Flynt/Features/Acf/AdminJs',
                'path' => 'Features/Acf/admin.js',
                'dependencies' => ['jquery']
                ]);
            });
        }
    }

    public static function init()
    {
        if (true === self::$requirementsMet) {
            self::initHelpers();
        } elseif (class_exists('Flynt\Features\AdminNotices\AdminNoticeManager')) {
            self::showAdminNotice();
        }
    }

    protected static function checkRequirements()
    {
        self::$requirements = [
        'acfEnabled' => class_exists('acf'),
        'acfFunctionsExist' => function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page'),
        'acfComposerEnabled' => class_exists('ACFComposer\ACFComposer'),
        ];
        return self::$requirements;
    }

    protected static function setupHelpers()
    {
        $namespacePrefix = 'Flynt\Features\Acf';
        foreach (self::$helpers as $helperName => $helperOptions) {
            $className = "{$namespacePrefix}\\$helperName";
            if (class_exists($className) && method_exists($className, 'setup')) {
                $className::setup($helperOptions);
            }
        }
    }

    protected static function initHelpers()
    {
        $namespacePrefix = 'Flynt\Features\Acf';
        foreach (self::$helpers as $helperName => $helperOptions) {
            $className = "{$namespacePrefix}\\$helperName";
            if (class_exists($className) && method_exists($className, 'init')) {
                $className::init($helperOptions);
            }
        }
    }

    protected static function showAdminNotice()
    {
        $messages = [];

        if (!self::$requirements['acfEnabled']) {
            $messages[] = 'Advanced Custom Fields Plugin not installed or activated. Make sure you <a href="'
            . esc_url(admin_url('plugins.php')) . '">install or activate the plugin</a>.';
        } elseif (!self::$requirements['acfFunctionsExist']) {
            $messages[] = 'Advanced Custom Fields Plugin Functions not found! Please make sure you are using'
            . ' the latest version of ACF.';
        }

        if (!self::$requirements['acfComposerEnabled']) {
            $messages[] = 'ACF Composer Plugin not installed or activated. Make sure you <a href="'
            . esc_url(admin_url('plugins.php')) . '">install or activate the plugin</a>.';
        }

        $manager = AdminNoticeManager::getInstance();
        $manager->addNotice($messages, [
            'title' => 'Could not initialize ACF Helpers (' . implode(', ', array_keys(self::$helpers)) . ')',
            'type' => 'warning',
            'dismissible' => true,
            'filenames' => basename(__DIR__)
        ]);
    }
}
