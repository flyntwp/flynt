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

class OptionPages {
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

  protected static $optionPages = [];
  protected static $optionTypes = [];
  protected static $optionCategories = [];

  public static function setup() {

    self::$optionTypes = self::OPTION_TYPES;
    self::$optionCategories = self::OPTION_CATEGORIES;

    self::createOptionPages();

    // Register Categories
    foreach (self::$optionCategories as $categoryName => $categorySettings) {
      $registerFn = 'registerOptionCategory' . ucfirst($categoryName);
      self::$registerFn();
    }

  }

  public static function init() {
    // show (dismissible) Admin Notice if required feature is missing
    if (class_exists('Flynt\Features\AdminNotices\AdminNoticeManager')) {

      self::checkFeature('customPostType', 'flynt-custom-post-types');
      self::checkFeature('component', 'flynt-components');

    }
  }

  // ============
  // PUBLIC API
  // ============

  // usage: OptionPages::getOptions('options', 'customPostType', 'myCustomPostTypeName');
  // usage: OptionPages::getOptions('options', 'feature', 'myFeatureName');
  // usage: OptionPages::getOptions('localeOptions', 'component', 'myComponentName');
  // all params expected to be camelCase
  public static function getOptions($optionType, $optionCategory, $subPageName) {
    if (!isset(self::$optionTypes[$optionType])) return [];

    $prefix = implode('', [$optionType, ucfirst($optionCategory), ucfirst($subPageName), '_']);
    $options = self::getOptionFields(self::$optionTypes[$optionType]['translatable']);

    // find and replace relevant keys, then return an array of all options for this Sub-Page
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

  // usage: OptionPages::getOption('options', 'customPostType', 'myCustomPostTypeName', 'myFieldName');
  // usage: OptionPages::getOption('options', 'feature', 'myFeatureName', 'myFieldName');
  // usage: OptionPages::getOption('localeOptions', 'component', 'myComponentName', 'myFieldName');
  // all params expected to be camelCase
  public static function getOption($optionType, $optionCategory, $subPageName, $fieldName) {
    $options = self::getOptions($optionType, $optionCategory, $subPageName);
    return array_key_exists($fieldName, $options) ? $options[$fieldName] : false;
  }

  // ============
  // COMPONENTS
  // ============

  protected static function registerOptionCategoryComponent() {
    add_action(
      'Flynt/registerComponent',
      ['Flynt\Features\Acf\OptionPages', 'addComponentSubPage'],
      12
    );

    add_filter('Flynt/addComponentData', function ($data, $parentData, $config) {

      // get fields for this component
      $options = array_reduce(array_keys(self::$optionTypes), function ($carry, $optionType) use ($config) {

        return array_merge($carry, self::getOptions($optionType, 'Component', $config['name']));

      }, []);

      // don't overwrite existing data
      return array_merge($options, $data);

    }, 10, 3);
  }

  public static function addComponentSubPage($componentName) {
    // load fields.json if it exists
    $componentManager = ComponentManager::getInstance();
    $filePath = $componentManager->getComponentFilePath($componentName, 'fields.json');

    if (false === $filePath) return;

    self::createSubPageFromConfig($filePath, 'component', $componentName);
  }

  // ==================
  // CUSTOM POST TYPES
  // ==================

  protected static function registerOptionCategoryCustomPostType() {
    add_action(
      'Flynt/Features/CustomPostTypes/Register',
      ['Flynt\Features\Acf\OptionPages', 'addCustomPostTypeSubPage'],
      10,
      2
    );
  }

  public static function addCustomPostTypeSubPage($name, $customPostType) {
    // load fields.json file
    $filePath = $customPostType['dir'] . '/fields.json';

    if (is_file($filePath)) {
      // TODO refactor
      // $cptName = ucfirst($cptDir->getFilename());
      // if (isset($cptConfig['label'])) {
      //   $label = $cptConfig['label'];
      // }
      // if (isset($cptConfig['labels'])) {
      //   if (isset($cptConfig['labels']['menu_name'])) {
      //     $label = $cptConfig['labels']['menu_name'];
      //   } else if (isset($cptConfig['labels']['singular_name'])) {
      //     $label = $cptConfig['labels']['singular_name'];
      //   }
      // }
      self::createSubPageFromConfig($filePath, 'customPostType', ucfirst($name));
    }
  }

  // ========
  // FEATURES
  // ========

  protected static function registerOptionCategoryFeature() {
    add_action(
      'Flynt/afterRegisterFeatures',
      ['Flynt\Features\Acf\OptionPages', 'addAllFeatureSubPages']
    );
  }

  public static function addAllFeatureSubPages() {

    foreach (Feature::getFeatures() as $featureName => $feature) {

      $filePath = $feature['dir'] . '/fields.json';

      if (!is_file($filePath)) continue;

      $featureName = StringHelpers::removePrefix('flynt', StringHelpers::kebapCaseToCamelCase($featureName));

      self::createSubPageFromConfig($filePath, 'feature', $featureName);

    }

  }

  // ========
  // GENERAL
  // ========

  protected static function createOptionPages() {

    foreach (self::$optionTypes as $optionType => $option) {
      $title = _x($option['title'], 'title', 'flynt-theme');
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
        $subPageId = StringHelpers::camelCaseToKebap($menuTitle) . '_page_' . $optionType;
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

  protected static function createSubPageFromConfig($filePath, $optionCategoryName, $subPageName) {
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::$optionTypes as $optionType => $option) {
      if (array_key_exists($optionType, $fields)) {
        self::addOptionSubPage(
          $optionCategoryName,
          ucfirst($subPageName),
          $optionType,
          $fields[$optionType]
        );
      }
    }
  }

  protected static function addOptionSubPage($optionCategoryName, $subPageName, $optionType, $fields) {
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

  protected static function addFieldGroupToSubPage($parentMenuSlug, $menuSlug, $prettySubPageName, $fields) {
    $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
      [
        'name' => $menuSlug,
        'title' => $prettySubPageName,
        'fields' => self::prefixFields($fields, $menuSlug),
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

    acf_add_local_field_group($fieldGroup);
  }

  protected static function checkFeature($optionCategory, $feature) {
    if (array_key_exists($optionCategory, self::$optionCategories) && !Feature::isRegistered($feature)) {
      $title = self::$optionCategories[$optionCategory]['title'];
      $noticeManager = AdminNoticeManager::getInstance();
      $noticeManager->addNotice(
        [
          "Could not add Option Pages for {$title} because the \"{$feature}\" feature is missing."
        ], [
          'title' => 'Acf Option Pages Feature',
          'dismissible' => true,
          'type' => 'info'
        ]
      );
    }
  }

  protected static function prefixFields($fields, $prefix) {
    return array_map(function ($field) use ($prefix) {
      $field['name'] = $prefix . '_' . $field['name'];
      return $field;
    }, $fields);
  }

  protected static function getOptionFields($translatable) {
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

  protected static function getCachedOptionFields($namespace = '') {
    // get cached options
    $found = false;
    $suffix = !empty($namespace) ? "_${namespace}" : '';
    $cacheKey = "Flynt/Features/Acf/OptionPages/ID=options${suffix}";

    $options = wp_cache_get($cacheKey, 'flynt', null, $found);

    if (!$found) {
      $options = get_fields('options');
      wp_cache_set($cacheKey, $options, 'flynt');
    }

    return $options;
  }

  protected static function combineArrayDefaults(array $array, array $defaults) {
    return array_map(function ($value) use ($defaults) {
      return is_array($value) ? array_merge($defaults, $value) : [];
    }, $array);
  }

  public static function getDefaultAcfLanguage() {
    return acf_get_setting('default_language');
  }
}
