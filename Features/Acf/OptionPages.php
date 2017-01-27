<?php

// TODO make order of option categories customizable (Components, CustomPostTypes, Features)
// TODO add option fields to Feature Options somehow
// TODO add custom post type label and option category showType functionality
// TODO add notice for meta keys that are too long (unsolved ACF / WordPress issue)

namespace Flynt\Features\Acf;

use ACFComposer;
use Flynt\ComponentManager;
use Flynt\Features\AdminNotices\AdminNoticeManager;
use Flynt\Features\Components\Component;
use Flynt\Features\CustomPostTypes\CustomPostTypeRegister;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

class OptionPages {
  const FILTER_NAMESPACE = 'Flynt/Components';
  const FIELD_GROUPS_DIR = '/config/fieldGroups';

  const OPTION_TYPE_DEFAULTS = [
    'translatable' => true
  ];

  protected static $optionPages = [];
  protected static $optionTypes = [];
  protected static $optionCategories = [];

  public static function setup(array $options) {

    $optionTypes = isset($options['optionTypes']) ? $options['optionTypes'] : [];
    $optionCategories = isset($options['optionCategories']) ? $options['optionCategories'] : [];

    self::$optionTypes = array_map(function ($optionType) {
      return is_array($optionType) ? array_merge(self::OPTION_TYPE_DEFAULTS, $optionType) : [];
    }, $optionTypes);

    // self::$optionCategories = $optionCategories;
    self::$optionCategories = $optionCategories;

    self::createOptionPages();

    // Components
    if (array_key_exists('component', self::$optionCategories)) {
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

    // Custom Post Types
    if (array_key_exists('customPostType', self::$optionCategories)) {
      add_action(
        'Flynt/Features/CustomPostTypes/Register',
        ['Flynt\Features\Acf\OptionPages', 'addCustomPostTypeSubPage'],
        10,
        2
      );
    }

    // Features
    if (array_key_exists('feature', self::$optionCategories)) {
      add_action(
        'Flynt/afterRegisterFeatures',
        ['Flynt\Features\Acf\OptionPages', 'addAllFeatureSubPages']
      );
    }

    // add styles for admin area
    add_action('admin_enqueue_scripts', function () {
      Component::addAsset('enqueue', [
        'type' => 'style',
        'name' => 'Flynt/Features/Acf/AdminCss',
        'path' => 'Features/Acf/admin.css'
      ]);
    });

    // TODO do a check on wp_loaded or admin_menu hook
    // self::removeEmptyOptionPages();
  }

  public static function init() {
    // show (dismissible) Admin Notice if required feature is missing
    if (class_exists('Flynt\Features\AdminNotices\AdminNoticeManager')) {

      self::checkFeature('customPostType', 'flynt-custom-post-types');
      self::checkFeature('component', 'flynt-components');

    }
  }

  public static function createOptionPages() {

    foreach (self::$optionTypes as $optionType => $option) {
      $title = _x($option['title'], 'title', 'flynt-theme');
      $slug = ucfirst($optionType);

      $generalSettings = acf_add_options_page(array(
        'page_title'  => $title,
        'menu_title'  => $title,
        'redirect'    => true,
        'menu_slug'   => $slug
      ));

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

  // usage: OptionPages::getOptions('flyntOptions', 'customPostType', 'project');
  // all params expected to be camelCase
  public static function getOptions($optionType, $optionCategory, $subPageName) {
    if (!isset(self::$optionTypes[$optionType])) return [];

    $prefix = implode('', [$optionType, ucfirst($optionCategory), ucfirst($subPageName), '_']);
    $options = self::getOptionFields(self::$optionTypes[$optionType]['translatable']);

    // find and replace relevant keys, then return an array of all options for this Sub-Page
    return array_reduce(array_keys($options), function ($carry, $key) use ($options, $prefix) {
      $count = 0;
      $option = $options[$key];
      $key = str_replace($prefix, '', $key, $count);
      if ($count > 0) {
        $carry[$key] = $option;
      }
      return $carry;
    }, []);
  }

  // usage: OptionPages::getOption('flyntOptions', 'customPostType', 'project', 'myFieldName');
  // all params expected to be camelCase
  public static function getOption($optionType, $optionCategory, $subPageName, $fieldName) {
    $options = self::getOptions($optionType, $optionCategory, $subPageName);
    return array_key_exists($fieldName, $options) ? $options[$fieldName] : false;
  }

  // ============
  // COMPONENTS
  // ============

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

  protected static function createSubPageFromConfig($filePath, $optionCategory, $subPageName) {
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::$optionTypes as $optionType => $option) {
      if (array_key_exists($optionType, $fields)) {
        self::addOptionSubPage(
          $optionCategory,
          ucfirst($subPageName),
          $optionType,
          $fields[$optionType]
        );
      }
    }
  }

  protected static function addOptionSubPage($optionCategory, $subPageName, $optionType, $fields) {
    $prettySubPageName = StringHelpers::splitCamelCase($subPageName);
    $iconClasses = 'flynt-submenu-item dashicons-before ' . self::$optionCategories[$optionCategory]['icon'];

    $subPageConfig = array(
      'page_title'  => $prettySubPageName . ' ' . self::$optionCategories[$optionCategory]['title'],
      'menu_title'  => "<span class='{$iconClasses}'>{$prettySubPageName}</span>",
      'parent_slug' => self::$optionPages[$optionType]['menu_slug'],
      'menu_slug'   => $optionType . ucfirst($optionCategory) . $subPageName
    );

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

  protected static function prefixFields(array $fields, string $prefix) {
    return array_map(function ($field) use ($prefix) {
      $field['name'] = $prefix . '_' . $field['name'];
      return $field;
    }, $fields);
  }

  protected static function getOptionFields(bool $translatable) {
    global $sitepress;

    if (!isset($sitepress) || $translatable) return get_fields('options');

    $sitepress->switch_lang(acf_get_setting('default_language'));
    add_filter('acf/settings/current_language', 'Flynt\Features\Acf\OptionPages::getDefaultAcfLanguage', 100);

    $options = get_fields('options');

    remove_filter('acf/settings/current_language', 'Flynt\Features\Acf\OptionPages::getDefaultAcfLanguage', 100);
    $sitepress->switch_lang(ICL_LANGUAGE_CODE);

    return $options;
  }

  public static function getDefaultAcfLanguage() {
    return acf_get_setting('default_language');
  }
}
