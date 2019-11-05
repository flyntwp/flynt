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
            'title' => 'Components'
        ],
        'feature' => [
            'title' => 'Features'
        ],
        'archive' => [
            'title' => 'Archives'
        ]
    ];

    protected static $initialized = false;

    protected static $optionPages = [];

    protected static $registeredOptions = [];

    protected static function createOptionPages()
    {
        if (static::$initialized) {
            return;
        } else {
            static::$initialized = true;
        }
        foreach (static::OPTION_TYPES as $optionType => $option) {
            $title = _x($option['title'], 'title', 'flynt');
            $slug = ucfirst($optionType);

            $pageConfig = [
                'page_title' => $title,
                'menu_title' => $title,
                'redirect' => true,
                'menu_slug' => $slug,
                'icon_url' => $option['icon']
            ];

            acf_add_options_page($pageConfig);

            static::$optionPages[$optionType] = [
                'menu_slug' => $slug,
                'menu_title' => $title
            ];

            // TODO: check if we can hide empty category pages
            foreach (static::OPTION_CATEGORIES as $optionCategory => $category) {
                $categoryTitle = _x($category['title'], 'title', 'flynt');
                $categorySlug = $slug . ucfirst($optionCategory);

                $pageConfig = [
                    'page_title' => $title . ': ' . $categoryTitle,
                    'menu_title' => $categoryTitle,
                    'redirect' => true,
                    'menu_slug' => $categorySlug,
                    'parent_slug' => $slug
                ];
                acf_add_options_page($pageConfig);

                static::$optionPages[$optionType]['sub_pages'][
                    $optionCategory
                ] = [
                    'menu_slug' => $categorySlug,
                    'menu_title' => $categoryTitle
                ];
                $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup([
                    'name' => $categorySlug,
                    'title' => $categoryTitle,
                    'style' => 'seamless',
                    'fields' => [],
                    'location' => [
                        [
                            [
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => $categorySlug
                            ]
                        ]
                    ]
                ]);
                acf_add_local_field_group($fieldGroup);
            }
        }

        add_action('current_screen', function ($currentScreen) {
            $currentScreenId = strtolower($currentScreen->id);
            foreach (static::OPTION_TYPES as $optionType => $option) {
                $isTranslatable = $option['translatable'];

                // NOTE: because the first subpage starts with toplevel instead (there is no overview page)
                $toplevelPageId = strtolower('toplevel_page_' . $optionType);
                $menuTitle = static::$optionPages[$optionType]['menu_title'];

                // NOTE: all other subpages have the parent menu-title in front instead
                $subPageId = strtolower(
                    sanitize_title($menuTitle) . '_page_' . $optionType
                );
                $isCurrentPage =
                    StringHelpers::startsWith(
                        $toplevelPageId,
                        $currentScreenId
                    ) ||
                    StringHelpers::startsWith($subPageId, $currentScreenId);

                if (!$isTranslatable && $isCurrentPage) {
                    // set acf field values to default language
                    add_filter(
                        'acf/settings/current_language',
                        'Flynt\Utils\Options::getDefaultAcfLanguage',
                        101
                    );

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
     * @param string $optionCategory Category of option sub page. One of these values: component, feature, archive.
     * @param string $groupName Name of the group on this page.
     * @param string $fieldName (optional) Name of the field to get.
     * @return mixed The value of the option or array of options. False if subpage doesn't exist or no option was found.
     **/
    public static function get(
        $optionType,
        $optionCategory,
        $groupName,
        $fieldName = null
    ) {
        if (!static::checkRequiredHooks(
            $optionType,
            $optionCategory,
            $groupName,
            $fieldName
        )
        ) {
            return false;
        }

        // convert parameters
        $optionType = lcfirst($optionType);
        $optionCategory = ucfirst($optionCategory);
        $groupName = ucfirst($groupName);

        if (!isset(static::OPTION_TYPES[$optionType])) {
            return false;
        }

        $prefix = implode('', [$optionType, $optionCategory, $groupName, '_']);
        $isTranslatable = static::OPTION_TYPES[$optionType]['translatable'];
        if (empty($fieldName)) {
            $optionNames =
                ((static::$registeredOptions[$optionType] ?? [])[
                    lcfirst($optionCategory)
                ] ?? [])[$groupName] ?? [];
            return array_combine(
                $optionNames,
                array_map(function ($optionName) use (
                    $prefix,
                    $isTranslatable
                ) {
                    $fieldKey = $prefix . $optionName;
                    return static::getOptionField($fieldKey, $isTranslatable);
                },
                $optionNames)
            );
        } else {
            $fieldKey = $prefix . $fieldName;
            return static::getOptionField($fieldKey, $isTranslatable);
        }
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
        $fieldGroupTitle = StringHelpers::splitCamelCase($scope);

        $optionsPageSlug =
            self::$optionPages[$type]['sub_pages'][$category]['menu_slug'];
        $fieldGroupName = $type . ucfirst($category) . $scope;
        static::addOptionsFieldGroup(
            $fieldGroupName,
            $fieldGroupTitle,
            $optionsPageSlug,
            $fields
        );
        static::registerOptionNames($type, $category, $scope, $fields);
    }

    protected static function registerOptionNames(
        $type,
        $category,
        $scope,
        $fields
    ) {
        static::$registeredOptions[$type] =
            static::$registeredOptions[$type] ?? [];
        static::$registeredOptions[$type][$category] =
            static::$registeredOptions[$type][$category] ?? [];
        static::$registeredOptions[$type][$category][$scope] = array_column(
            $fields,
            'name'
        );
        return static::$registeredOptions;
    }

    protected static function addOptionsFieldGroup(
        $name,
        $title,
        $optionsPageSlug,
        $fields
    ) {
        $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup([
            'name' => $name,
            'title' => $title,
            'fields' => array_merge(
                [
                    [
                        'label' => $title,
                        'name' => '',
                        'type' => 'accordion',
                        'placement' => 'left',
                        'endpoint' => false
                    ]
                ],
                $fields
            ),
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
        ]);
        $fieldGroup['fields'] = static::prefixFields(
            $fieldGroup['fields'],
            $name
        );
        foreach ($fieldGroup['fields'] as $field) {
            acf_add_local_field(
                array_merge($field, [
                    'parent' => 'group_' . $optionsPageSlug
                ])
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

    protected static function checkRequiredHooks(
        $optionType,
        $optionCategory,
        $groupName,
        $fieldName
    ) {
        if (did_action('acf/init') < 1) {
            $parameters = "${optionType}, ${optionCategory}, ${groupName}, ";
            $parameters .= isset($fieldName) ? $fieldName : 'NULL';
            trigger_error(
                "Could not get option/s for [${parameters}]. Required hooks have not yet been executed! Please make sure to run `Options::get()` after the `acf/init` action is finished.",
                E_USER_WARNING
            );
            return false;
        }
        return true;
    }

    protected static function getOptionField($key, $translatable)
    {
        if ($translatable) {
            $option = get_field('field_' . $key, 'option');
        } else {
            // switch to default language to get global options
            add_filter(
                'acf/settings/current_language',
                'Flynt\Utils\Options::getDefaultAcfLanguage',
                100
            );

            $option = get_field('field_' . $key, 'option');

            remove_filter(
                'acf/settings/current_language',
                'Flynt\Utils\Options::getDefaultAcfLanguage',
                100
            );
        }

        return $option;
    }

    public static function getDefaultAcfLanguage()
    {
        return acf_get_setting('default_language');
    }
}
