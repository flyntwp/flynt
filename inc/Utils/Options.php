<?php

namespace Flynt\Utils;

use ACFComposer;

class Options
{
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

    protected static $initialized = false;

    protected static $optionPages = [];

    protected static function createOptionPages()
    {
        if (static::$initialized) {
            return;
        } else {
            static::$initialized = true;
        }
        foreach (static::OPTION_TYPES as $optionType => $option) {
            $title = _x($option['title'], 'title', 'flynt-starter-theme');
            $slug = ucfirst($optionType);

            acf_add_options_page([
                'page_title'  => $title,
                'menu_title'  => $title,
                'redirect'    => true,
                'menu_slug'   => $slug,
                'icon_url'    => $option['icon']
            ]);

            static::$optionPages[$optionType] = [
                'menu_slug' => $slug,
                'menu_title' => $title
            ];
            $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
                [
                    'name' => $slug,
                    'title' => $title,
                    'style' => 'seamless',
                    'fields' => [],
                    'location' => [
                        [
                            [
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => $slug
                            ]
                        ]
                    ]
                ]
            );
            acf_add_local_field_group($fieldGroup);
        }

        add_action('current_screen', function ($currentScreen) {
            foreach (static::OPTION_TYPES as $optionType => $option) {
                $isTranslatable = $option['translatable'];
                $toplevelPageId = 'toplevel_page_' . $optionType;
                $menuTitle = static::$optionPages[$optionType]['menu_title'];
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


    // ============
    // PUBLIC API
    // ============

    /**
     * Get option(s) from a sub page.
     *
     * Returns an option of a sub page. If no field name is provided it will get all option of that sub page.
     * Parameters are expected to be camelCase.
     *
     * @since 0.2.0 introduced as a replacement for OptionPages::getOption and OptionPages::getOptions
     * @since 0.2.2 added check for required hooks to have run to alert of timing issues when used incorrectly
     *
     * @param string $optionType Type of option page. Either globalOptions or translatableOptions.
     * @param string $optionCategory Category of option page. One of these three values: component, feature, customPostType.
     * @param string $subPageName Name of the sub page.
     * @param string $fieldName (optional) Name of the field to get.
     * @return mixed The value of the option or array of options. False if subpage doesn't exist or no option was found.
     **/
    public static function get($optionType, $optionCategory, $subPageName, $fieldName = null)
    {
        if (!static::checkRequiredHooks($optionType, $optionCategory, $subPageName, $fieldName)) {
            return false;
        }

        // convert parameters
        $optionType = lcfirst($optionType);
        $optionCategory = ucfirst($optionCategory);
        $subPageName = ucfirst($subPageName);

        if (!isset(static::OPTION_TYPES[$optionType])) {
            return false;
        }

        $prefix = implode('', [$optionType, $optionCategory, $subPageName, '_']);
        $options = static::getOptionFields(static::OPTION_TYPES[$optionType]['translatable']);
        $options = static::collectOptionsWithPrefix($options, $prefix);

        if (isset($fieldName)) {
            $fieldName = lcfirst($fieldName);
            return array_key_exists($fieldName, $options) ? $options[$fieldName] : false;
        }
        return $options;
    }

    public static function addTranslatable($scope, $fields, $category = null)
    {
        static::addOptions($scope, $fields, 'translatableOptions', $category);
    }

    public static function addGlobal($scope, $fields, $category = null)
    {
        static::addOptions($scope, $fields, 'globalOptions', $category);
    }

    public static function addOptions($scope, $fields, $type, $category = null)
    {
        static::createOptionPages();
        if (empty($category)) {
            global $flyntCurrentOptionCategory;
            $category = $flyntCurrentOptionCategory ?? 'component';
        }
        $optionCategorySettings = static::OPTION_CATEGORIES[$category];
        $iconClasses = 'flynt-submenu-item dashicons-before ' . $optionCategorySettings['icon'];
        $prettyScope = StringHelpers::splitCamelCase($scope);
        $fieldGroupTitle = "<span class='{$iconClasses}'>{$prettyScope}</span>";
        $optionsPageSlug = self::$optionPages[$type]['menu_slug'];
        $fieldGroupName = $type . ucfirst($category) . $scope;
        static::addOptionsFieldGroup($fieldGroupName, $fieldGroupTitle, $optionsPageSlug, $fields);
    }

    protected static function addOptionsFieldGroup($name, $title, $optionsPageSlug, $fields)
    {
        $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
            [
                'name' => $name,
                'title' => $title,
                'fields' => array_merge([
                    [
                        'label' => $title,
                        'name' => '',
                        'type' => 'accordion',
                        'placement' => 'left',
                        'endpoint' => false,
                    ]
                ], $fields),
                'style' => 'seamless',
                'location' => [
                    [
                        [
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => $optionsPageSlug
                        ]
                    ]
                ]
            ]
        );
        $fieldGroup['fields'] = static::prefixFields($fieldGroup['fields'], $name);
        foreach ($fieldGroup['fields'] as $field) {
            acf_add_local_field(array_merge($field, [
                'parent' => 'group_' . $optionsPageSlug,
            ]));
        }
        // acf_add_local_field_group($fieldGroup);
    }

    protected static function prefixFields($fields, $prefix)
    {
        return array_map(function ($field) use ($prefix) {
            $field['name'] = $prefix . '_' . $field['name'];
            return $field;
        }, $fields);
    }

    protected static function checkRequiredHooks($optionType, $optionCategory, $subPageName, $fieldName)
    {
        if (did_action('acf/init') < 1) {
            $parameters = "${optionType}, ${optionCategory}, ${subPageName}, ";
            $parameters .= isset($fieldName) ? $fieldName : 'NULL';
            trigger_error("Could not get option/s for [${parameters}]. Required hooks have not yet been executed! Please make sure to run `OptionPages::get()` after the `acf/init` action is finished.", E_USER_WARNING);
            return false;
        }
        return true;
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

    // find and replace relevant keys, then return an array of all options for this Sub-Page
    protected static function collectOptionsWithPrefix($options, $prefix)
    {
        $optionKeys = is_array($options) ? array_keys($options) : [];
        return array_reduce($optionKeys, function ($carry, $key) use ($options, $prefix) {
            $count = 0;
            $option = $options[$key];
            $key = str_replace($prefix, '', $key, $count);
            if ($count > 0) {
                $carry[$key] = $option;
            }
            return $carry;
        }, []);
    }
}
