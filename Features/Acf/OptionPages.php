<?php

// TODO adjust readme
// TODO [minor] Overview Page + setting for redirect
// TODO [minor] add custom post type label
// TODO [minor] add notice for meta keys that are too long (unsolved ACF / WordPress issue)
// TODO [minor] remove / don't create empty (parent) option pages

namespace Flynt\Features\Acf;

use ACFComposer;
use Flynt\ComponentManager;
use Flynt\Features\AdminNotices\AdminNoticeManager;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

class OptionPages
{
    const FIELD_GROUPS_DIR = '/config/fieldGroups';

    const OPTION_TYPES = [
        'translatableOptions' => [
            'title' => 'Translatable Options',
            'icon' => 'dashicons-translation',
            'translatable' => true
        ],
        'globalOptions' => [
            'title' => 'Global Options',
            'icon' => 'dashicons-admin-site',
            'translatable' => false
        ]
    ];

    const OPTION_CATEGORIES = [
        'component' => [
            'title' => 'Component',
            'icon' => 'dashicons-editor-table',
            'showType' => true
        ],
        'customPostType' => [
            'title' => 'Custom Post Type',
            'icon' => 'dashicons-palmtree',
            'showType' => true
            // 'label' => [ 'labels', 'menu_item' ], // TODO add this functionality
        ],
        'feature' => [
            'title' => 'Feature',
            'icon' => 'dashicons-carrot',
            'showType' => true
        ]
    ];

    const FILTER_NAMESPACES = [
        'component' => 'Flynt/Components',
        'customPostType' => 'Flynt/CustomPostTypes',
        'feature' => 'Flynt/Features'
    ];

    protected static $optionPages = [];
    protected static $optionTypes = [];
    protected static $optionCategories = [];

    public static function setup()
    {

        self::$optionTypes = self::OPTION_TYPES;
        self::$optionCategories = self::OPTION_CATEGORIES;

        self::createOptionPages();

        // Register Categories
        add_action('acf/init', function () {
            self::addComponentSubPages();
            self::addFeatureSubPages();
            self::addCustomPostTypeSubPages();
        });

        add_filter(
            'Flynt/addComponentData',
            ['Flynt\Features\Acf\OptionPages', 'addComponentData'],
            10,
            3
        );

        // Setup Flynt Non Persistent Cache
        wp_cache_add_non_persistent_groups('flynt');
    }

    public static function init()
    {
        // show (dismissible) Admin Notice if required feature is missing
        if (class_exists('Flynt\Features\AdminNotices\AdminNoticeManager')) {
            self::checkFeature('customPostType', 'flynt-custom-post-types');
            self::checkFeature('component', 'flynt-components');
        }
    }

    // ============
    // PUBLIC API
    // ============

    /**
     * Get option(s) from a sub page.
     *
     * Returns an option of a sub page. If no field name is provided it will get all option of that sub page.
     * Parameters are expected to be camelCase.
     *
     * @param string $optionType Type of option page. Either globalOptions or translatableOptions.
     * @param string $optionCategory Category of option page. One of these three values: component, feature, customPostType.
     * @param string $subPageName Name of the sub page.
     * @param string $fieldName (optional) Name of the field to get.
     * @return mixed The value of the option or array of options. False if subpage doesn't exist or no option was found.
     **/
    public static function get($optionType, $optionCategory, $subPageName, $fieldName = null)
    {
        $optionType = lcfirst($optionType);

        if (!isset(self::$optionTypes[$optionType])) {
            return false;
        }

        $optionCategory = ucfirst($optionCategory);
        $subPageName = ucfirst($subPageName);

        $prefix = implode('', [$optionType, $optionCategory, $subPageName, '_']);
        $options = self::getOptionFields(self::$optionTypes[$optionType]['translatable']);

        // find and replace relevant keys, then return an array of all options for this Sub-Page
        $optionKeys = is_array($options) ? array_keys($options) : [];
        $options = array_reduce($optionKeys, function ($carry, $key) use ($options, $prefix) {
            $count = 0;
            $option = $options[$key];
            $key = str_replace($prefix, '', $key, $count);
            if ($count > 0) {
                $carry[$key] = $option;
            }
            return $carry;
        }, []);

        if (isset($fieldName)) {
            $fieldName = lcfirst($fieldName);
            return array_key_exists($fieldName, $options) ? $options[$fieldName] : false;
        }
        return $options;
    }

    // ============
    // COMPONENTS
    // ============

    public static function addComponentData($data, $parentData, $config)
    {
        // get fields for this component
        $options = array_reduce(array_keys(self::$optionTypes), function ($carry, $optionType) use ($config) {
            return array_merge($carry, self::get($optionType, 'Component', $config['name']));
        }, []);

        // don't overwrite existing data
        return array_merge($options, $data);
    }

    public static function addComponentSubPages()
    {
        // load fields.json if it exists
        $componentManager = ComponentManager::getInstance();
        $components = $componentManager->getAll();

        foreach ($components as $name => $path) {
            self::createSubPage('component', $name);
        }
    }

    // ==================
    // CUSTOM POST TYPES
    // ==================

    public static function addCustomPostTypeSubPages()
    {
        $customPostTypes = CustomPostTypeRegister::getAll();

        foreach ($customPostTypes as $name => $config) {
            self::createSubPage('customPostType', $name);
        }
    }

    // ========
    // FEATURES
    // ========

    public static function addFeatureSubPages()
    {
        foreach (Feature::getFeatures() as $handle => $config) {
            self::createSubPage('feature', $config['name']);
        }
    }

    // ========
    // GENERAL
    // ========

    protected static function createOptionPages()
    {

        foreach (self::$optionTypes as $optionType => $option) {
            $title = _x($option['title'], 'title', 'flynt-starter-theme');
            $slug = ucfirst($optionType);

            acf_add_options_page([
                'page_title'  => $title,
                'menu_title'  => $title,
                'redirect'    => true,
                'menu_slug'   => $slug,
                'icon_url'    => $option['icon']
            ]);

            self::$optionPages[$optionType] = [
                'menu_slug' => $slug,
                'menu_title' => $title
            ];
        }

        add_action('current_screen', function ($currentScreen) {
            foreach (self::$optionTypes as $optionType => $option) {
                $isTranslatable = $option['translatable'];
                $toplevelPageId = 'toplevel_page_' . $optionType;
                $menuTitle = self::$optionPages[$optionType]['menu_title'];
                $subPageId = sanitize_title($menuTitle) . '_page_' . $optionType;
                $isCurrentPage = StringHelpers::startsWith($toplevelPageId, $currentScreen->id)
                || StringHelpers::startsWith($subPageId, $currentScreen->id);

                if (!$isTranslatable && $isCurrentPage) {
                    // set acf field values to default language
                    add_filter('acf/settings/current_language', 'Flynt\Features\Acf\OptionPages::getDefaultAcfLanguage', 101);

                    // hide language selector in admin bar
                    add_action('wp_before_admin_bar_render', function () {
                        $adminBar = $GLOBALS['wp_admin_bar'];
                        $adminBar->remove_menu('WPML_ALS');
                    });
                }
            }
        });
    }

    protected static function createSubPage($type, $name)
    {
        $namespace = self::FILTER_NAMESPACES[$type];
        foreach (self::$optionTypes as $optionType => $option) {
            $filterName = "{$namespace}/{$name}/Fields/" . ucfirst($optionType);
            $fields = apply_filters($filterName, []);
            if (!empty($fields)) {
                self::addOptionSubPage(
                    $type,
                    ucfirst($name),
                    $optionType,
                    $fields
                );
            }
        }
    }

    protected static function addOptionSubPage($optionCategoryName, $subPageName, $optionType, $fields)
    {
        $prettySubPageName = StringHelpers::splitCamelCase($subPageName);
        $optionCategorySettings = self::$optionCategories[$optionCategoryName];
        $iconClasses = 'flynt-submenu-item dashicons-before ' . $optionCategorySettings['icon'];

        $appendCategory = '';
        if (isset($optionCategorySettings['showType']) && true === $optionCategorySettings['showType']) {
            $appendCategory = ' (' . $optionCategorySettings['title'] . ')';
        }

        $subPageConfig = [
            'page_title'  => $prettySubPageName . $appendCategory,
            'menu_title'  => "<span class='{$iconClasses}'>{$prettySubPageName}</span>",
            'parent_slug' => self::$optionPages[$optionType]['menu_slug'],
            'menu_slug'   => $optionType . ucfirst($optionCategoryName) . $subPageName
        ];

        acf_add_options_sub_page($subPageConfig);

        self::addFieldGroupToSubPage(
            $subPageConfig['parent_slug'],
            $subPageConfig['menu_slug'],
            $subPageConfig['menu_title'],
            $fields
        );
    }

    protected static function addFieldGroupToSubPage($parentMenuSlug, $menuSlug, $prettySubPageName, $fields)
    {
        $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
            [
                'name' => $menuSlug,
                'title' => $prettySubPageName,
                'fields' => $fields,
                'style' => 'seamless',
                'location' => [
                    [
                        [
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => $menuSlug
                        ]
                    ]
                ]
            ]
        );
        $fieldGroup['fields'] = self::prefixFields($fieldGroup['fields'], $menuSlug);
        acf_add_local_field_group($fieldGroup);
    }

    protected static function checkFeature($optionCategory, $feature)
    {
        if (array_key_exists($optionCategory, self::$optionCategories) && !Feature::isRegistered($feature)) {
            $title = self::$optionCategories[$optionCategory]['title'];
            $noticeManager = AdminNoticeManager::getInstance();
            $noticeManager->addNotice(
                [
                    "Could not add Option Pages for {$title} because the \"{$feature}\" feature is missing."
                ],
                [
                    'title' => 'Acf Option Pages Feature',
                    'dismissible' => true,
                    'type' => 'info'
                ]
            );
        }
    }

    protected static function prefixFields($fields, $prefix)
    {
        return array_map(function ($field) use ($prefix) {
            $field['name'] = $prefix . '_' . $field['name'];
            return $field;
        }, $fields);
    }

    protected static function getOptionFields($translatable)
    {
        global $sitepress;

        if (!isset($sitepress)) {
            $options = self::getCachedOptionFields();
        } else if ($translatable) {
            // get options from cache with language namespace
            $options = self::getCachedOptionFields(ICL_LANGUAGE_CODE);
        } else {
            // switch to default language to get global options
            $sitepress->switch_lang(acf_get_setting('default_language'));

            add_filter('acf/settings/current_language', 'Flynt\Features\Acf\OptionPages::getDefaultAcfLanguage', 100);

            // get optios from cache with global namespace
            $options = self::getCachedOptionFields('global');

            remove_filter('acf/settings/current_language', 'Flynt\Features\Acf\OptionPages::getDefaultAcfLanguage', 100);

            $sitepress->switch_lang(ICL_LANGUAGE_CODE);
        }

        return $options;
    }

    protected static function getCachedOptionFields($namespace = '')
    {
        // get cached options
        $found = false;
        $suffix = !empty($namespace) ? "_${namespace}" : '';
        $cacheKey = "Features/Acf/OptionPages/ID=options${suffix}";

        $options = wp_cache_get($cacheKey, 'flynt', null, $found);

        if (!$found) {
            $options = get_fields('options');
            wp_cache_set($cacheKey, $options, 'flynt');
        }

        return $options;
    }

    protected static function combineArrayDefaults(array $array, array $defaults)
    {
        return array_map(function ($value) use ($defaults) {
            return is_array($value) ? array_merge($defaults, $value) : [];
        }, $array);
    }

    public static function getDefaultAcfLanguage()
    {
        return acf_get_setting('default_language');
    }
}
