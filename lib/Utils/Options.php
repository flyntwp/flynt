<?php

namespace Flynt\Utils;

use ACFComposer;

/**
 * Provides a set of methods that are used to register options pages and options fields.
 * It also provides a set of methods that are used to get the values of options fields.
 */
class Options
{
    public const OPTION_TYPES = [
        'translatable' => [
            'title' => 'Translatable Options',
            'icon' => 'dashicons-translation',
            'translatable' => true
        ],
        'global' => [
            'title' => 'Global Options',
            'icon' => 'dashicons-admin-site',
            'translatable' => false
        ]
    ];

    /**
     * The initialized state of the class.
     *
     * @var boolean
     */
    protected static $initialized = false;

    /**
     * The internal list (array) of options pages.
     *
     * @var array
     */
    protected static $optionPages = [];

    /**
     * The internal list (array) of registered options.
     *
     * @var array
     */
    protected static $registeredOptions = [];

    /**
     * Initialize the class.
     */
    public static function init(): void
    {
        if (static::$initialized) {
            return;
        }

        static::$initialized = true;

        add_action('current_screen', function ($currentScreen): void {
            $currentScreenId = strtolower($currentScreen->id);
            foreach (static::OPTION_TYPES as $optionType => $option) {
                $isTranslatable = $option['translatable'];
                // NOTE: because the first subpage starts with toplevel instead (there is no overview page).
                $toplevelPageId = strtolower('toplevel_page_' . $optionType);
                $menuTitle = static::$optionPages[$optionType]['menu_title'];
                // NOTE: all other subpages have the parent menu-title in front instead.
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
                    // Set acf field values to default language.
                    add_filter('acf/settings/current_language', [self::class, 'getDefaultAcfLanguage'], 101);
                    // Hide language selector in admin bar.
                    add_action('wp_before_admin_bar_render', function (): void {
                        $adminBar = $GLOBALS['wp_admin_bar'];
                        $adminBar->remove_menu('WPML_ALS');
                    });
                }
            }
        });
    }

    /**
     * Create an options page.
     *
     * @param string $optionType The type of the options page.
     *
     * @return array The option pages.
     */
    protected static function createOptionPage(string $optionType)
    {
        if (empty(static::$optionPages[$optionType])) {
            $option = static::OPTION_TYPES[$optionType];
            $title = _x($option['title'], 'title', 'flynt');
            $slug = ucfirst($optionType) . 'Options';

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
        }

        return static::$optionPages[$optionType];
    }

    /**
     * Create an options sub page.
     *
     * @param string $optionType The type of the options page.
     * @param string $optionCategory The category of the options page in camel case.
     *
     * @return void
     */
    protected static function createOptionSubPage(string $optionType, string $optionCategory = "Default")
    {
        if (empty(static::$optionPages[$optionType]['sub_pages'][$optionCategory])) {
            $optionPage = static::createOptionPage($optionType);
            $categoryTitle = _x($optionCategory, 'title', 'flynt');
            $categoryTitleSplit = StringHelpers::splitCamelCase($categoryTitle);
            $categorySlug = implode('-', [$optionPage['menu_slug'], $optionCategory]);
            $pageConfig = [
                'page_title' => $optionPage['menu_title'] . ': ' . $categoryTitleSplit,
                'menu_title' => $categoryTitleSplit,
                'redirect' => true,
                'menu_slug' => $categorySlug,
                'parent_slug' => $optionPage['menu_slug']
            ];
            acf_add_options_page($pageConfig);
            static::$optionPages[$optionType]['sub_pages'][$optionCategory] = [
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


    // ============
    // PUBLIC API
    // ============

    /**
     * Get fields from translatable options page.
     *
     * @param string $scope Scope of the option.
     * @param string|null $fieldName Name of the field.
     *
     * @return mixed
     */
    public static function getTranslatable(string $scope, string $fieldName = null)
    {
        return self::get('translatable', $scope, $fieldName);
    }

    /**
     * Get fields from global options page.
     *
     * @param string $scope Scope of the option.
     * @param string|null $fieldName Name of the field.
     *
     * @return mixed
     */
    public static function getGlobal(string $scope, ?string $fieldName = null)
    {
        return self::get('global', $scope, $fieldName);
    }

    /**
     * Get option(s) from a sub page.
     *
     * Returns an option of a sub page. If no field name is provided it will get all option of that sub page.
     * Parameters are expected to be camelCase.
     *
     * @since 0.2.0 introduced as a replacement for OptionPages::getOption and OptionPages::getOptions
     * @since 0.2.2 added check for required hooks to have run to alert of timing issues when used incorrectly
     *
     * @param string $optionType Type of option page. Either global or translatable.
     * @param string $scope Scope of the option.
     * @param string|null $fieldName Name of the field to get.
     * @return mixed The value of the option or array of options. False if subpage doesn't exist or no option was found.
     **/
    public static function get(string $optionType, string $scope, ?string $fieldName = null)
    {
        if (!static::checkRequiredHooks($optionType, $scope, $fieldName)) {
            return false;
        }

        // Convert parameters.
        $optionType = lcfirst($optionType);
        $scope = ucfirst($scope);

        if (!isset(static::OPTION_TYPES[$optionType])) {
            return false;
        }

        $prefix = implode('_', [$optionType, $scope, '']);
        $isTranslatable = static::OPTION_TYPES[$optionType]['translatable'];
        if ($fieldName === null || $fieldName === '' || $fieldName === '0') {
            $optionNames = ((static::$registeredOptions[$optionType] ?? [])[$scope] ?? []);
            return array_combine(
                $optionNames,
                array_map(function (string $optionName) use ($prefix, $isTranslatable) {
                    $fieldKey = $prefix . $optionName;
                    return static::getOptionField($fieldKey, $isTranslatable);
                }, $optionNames)
            );
        }

        $fieldKey = $prefix . $fieldName;
        return static::getOptionField($fieldKey, $isTranslatable);
    }

    /**
     * Add fields to translatable options page.
     *
     * @param string $scope Scope of the option.
     * @param array $fields Fields to add.
     * @param string $category Category of the option.
     */
    public static function addTranslatable(string $scope, array $fields, string $category = 'Default'): void
    {
        static::addOptions($scope, $fields, 'translatable', $category);
    }

    /**
     * Add fields to global options page.
     *
     * @param string $scope Scope of the option.
     * @param array $fields Fields to add.
     * @param string $category Category of the option.
     */
    public static function addGlobal(string $scope, array $fields, string $category = 'Default'): void
    {
        static::addOptions($scope, $fields, 'global', $category);
    }

    /**
     * Add options to a options page.
     *
     * @param string $scope Scope of the option.
     * @param array $fields Fields to add.
     * @param string $type Type of the option page.
     * @param string $category Category of the option.
     */
    public static function addOptions(string $scope, array $fields, string $type, string $category = 'Default'): void
    {
        static::createOptionSubPage($type, $category);
        $fieldGroupTitle = StringHelpers::splitCamelCase($scope);
        $optionsPageSlug = self::$optionPages[$type]['sub_pages'][$category]['menu_slug'];
        $fieldGroupName = implode('_', [$type, $scope]);
        static::addOptionsFieldGroup(
            $fieldGroupName,
            $fieldGroupTitle,
            $optionsPageSlug,
            $fields
        );
        static::registerOptionNames($type, $scope, $fields);
    }

    /**
     * Register option names.
     *
     * @param string $type Type of the option page.
     * @param string $scope Scope of the option.
     * @param array $fields Fields to add.
     *
     * @return array
     */
    protected static function registerOptionNames(string $type, string $scope, array $fields)
    {
        static::$registeredOptions[$type] ??= [];
        static::$registeredOptions[$type][$scope] = array_column($fields, 'name');
        return static::$registeredOptions;
    }

    /**
     * Add options field group.
     *
     * @param string $name Name of the field group.
     * @param string $title Title of the field group.
     * @param string $optionsPageSlug Slug of the options page.
     * @param array $fields Fields to add.
     *
     * @return void
     */
    protected static function addOptionsFieldGroup(string $name, string $title, string $optionsPageSlug, array $fields)
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
    }

    /**
     * Prefix fields.
     *
     * @param array $fields Fields to prefix.
     * @param string $prefix Prefix to add.
     */
    protected static function prefixFields(array $fields, string $prefix): array
    {
        return array_map(function (array $field) use ($prefix): array {
            $field['name'] = $prefix . '_' . $field['name'];
            return $field;
        }, $fields);
    }

    /**
     * Check required hooks.
     *
     * @param string $optionType Type of the option page.
     * @param string $scope Scope of the option.
     * @param string $fieldName Name of the field.
     */
    protected static function checkRequiredHooks(string $optionType, string $scope, ?string $fieldName = null): bool
    {
        if (did_action('acf/init') < 1) {
            $parameters = "{$optionType}, {$scope}, ";
            $parameters .= $fieldName ?? 'NULL';
            trigger_error("Could not get option/s for [{$parameters}]. Required hooks have not yet been executed! Please make sure to run `Options::get()` after the `acf/init` action is finished.", E_USER_WARNING);
            return false;
        }

        return true;
    }

    /**
     * Get option field.
     *
     * @param string $key Key of the field.
     * @param boolean $isTranslatable Whether the field is translatable.
     *
     * @return mixed
     */
    protected static function getOptionField(string $key, bool $isTranslatable)
    {
        if ($isTranslatable) {
            $option = get_field('field_' . $key, 'option');
        } else {
            // Switch to default language to get global options.
            add_filter('acf/settings/current_language', [self::class, 'getDefaultAcfLanguage'], 100);
            $option = get_field('field_' . $key, 'option');
            remove_filter('acf/settings/current_language', [self::class, 'getDefaultAcfLanguage'], 100);
        }

        return $option;
    }

    /**
     * Get default ACF language.
     *
     * @return string
     */
    public static function getDefaultAcfLanguage()
    {
        return acf_get_setting('default_language');
    }
}
