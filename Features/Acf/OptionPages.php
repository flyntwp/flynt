<?php

// TODO make global fields untranslatable
// TODO make order of option categories customizable (Components, CustomPostTypes, Features)

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

  const OPTION_TYPES = [
    'flyntOptions' => [
      'title' => 'Options',
      'name' => 'options',
      // 'translatable' => false
    ],
    'flyntLocaleOptions' => [
      'title' => 'Locale Options',
      'name' => 'localeOptions'
    ]
  ];

  const OPTION_CATEGORIES = [
    'component' => [
      'title' => 'Component',
      'name' => 'component',
      'icon' => 'dashicons-editor-table'
    ],
    'customPostType' => [
      'title' => 'Custom Post Type',
      'name' => 'customPostType',
      'icon' => 'dashicons-palmtree',
      // 'label' => [ 'labels', 'menu_item' ],
      // 'showType' => false
    ],
    'feature' => [
      'title' => 'Feature',
      'name' => 'feature',
      'icon' => 'dashicons-carrot'
    ]
  ];

  protected static $optionPages = [];

  public static function setup() {
    self::createOptionPages();

    // Components
    if (array_key_exists('component', self::OPTION_CATEGORIES)) {
      add_action(
        'Flynt/registerComponent',
        ['Flynt\Features\Acf\OptionPages', 'addComponentSubPage'],
        12
      );
    }

    // Custom Post Types
    if (array_key_exists('customPostType', self::OPTION_CATEGORIES)) {
      add_action(
        'Flynt/Features/CustomPostTypes/Register',
        ['Flynt\Features\Acf\OptionPages', 'addCustomPostTypeSubPage'],
        10,
        2
      );
    }

    // Features
    if (array_key_exists('feature', self::OPTION_CATEGORIES)) {
      add_action(
        'Flynt/initFeature',
        ['Flynt\Features\Acf\OptionPages', 'addFeatureSubPage'],
        10,
        3
      );
    }

    // add styles for admin area
    add_action('admin_enqueue_scripts', function () {
      Component::addAsset('enqueue', [
        'type' => 'style',
        'name' => 'ACF/AdminCSS',
        'path' => 'Features/Acf/admin.css'
      ]);
    });

    // TODO do a check on wp_loaded or admin_menu hook
    // self::removeEmptyOptionPages();
  }

  public static function init() {

    if (class_exists('Flynt\Features\AdminNotices\AdminNoticeManager')) {
      // show (dismissible) Admin Notice if feature is missing
      if (!Feature::isRegistered('flynt-custom-post-types')) {
        $noticeManager = AdminNoticeManager::getInstance();
        $noticeManager->addNotice(
          [
            'Could not add Option Pages for Custom Post Types because the "flynt-custom-post-types" feature is missing.'
          ], [
            'title' => 'Acf Option Pages Feature',
            'dismissible' => true,
            'type' => 'info'
          ]
        );
      }

      // TODO do the same for components
    }


  }

  public static function createOptionPages() {
    foreach (self::OPTION_TYPES as $optionType => $option) {
      $title = _x($option['title'], 'title', 'flynt-theme');
      $slug = _x(ucfirst($optionType), 'slug', 'flynt-theme'); // what does this even do?

      $generalSettings = acf_add_options_page(array(
        'page_title'  => $title,
        'menu_title'  => $title,
        'redirect'    => true,
        'menu_slug'   => $slug
      ));

      self::$optionPages[$optionType] = [
        'menu_slug' => $slug
      ];
    }
  }

  // ============
  // COMPONENTS
  // ============

  public static function addComponentSubPage($componentName) {
    // load fields.json if it exists
    $componentManager = ComponentManager::getInstance();
    $filePath = $componentManager->getComponentFilePath($componentName, 'fields.json');

    if (false === $filePath) {
      return;
    }

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

  public static function addFeatureSubPage($featureName, $options, $dir) {
    $filePath = $dir . '/fields.json';

    if (!is_file($filePath)) {
      return;
    }

    $featureName = StringHelpers::removePrefix('flynt', StringHelpers::kebapCaseToCamelCase($featureName));

    self::createSubPageFromConfig($filePath, 'feature', $featureName);
  }

  // ========
  // GENERAL
  // ========

  protected static function createSubPageFromConfig($filePath, $optionCategory, $subPageName) {
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::OPTION_TYPES as $optionType => $option) {
      if (array_key_exists($option['name'], $fields)) {
        self::addOptionSubPage(
          self::OPTION_CATEGORIES[$optionCategory],
          ucfirst($subPageName),
          $optionType,
          $fields[$option['name']]
        );
      }
    }
  }

  protected static function addOptionSubPage($optionCategory, $subPageName, $optionType, $fields) {
    $prettySubPageName = StringHelpers::splitCamelCase($subPageName);
    $iconClasses = "flynt-submenu-item dashicons-before {$optionCategory['icon']}";

    $subPageConfig = array(
      'page_title'  => $prettySubPageName . ' ' . $optionCategory['title'],
      'menu_title'  => "<span class='{$iconClasses}'>{$prettySubPageName}</span>",
      'parent_slug' => self::$optionPages[$optionType]['menu_slug'],
      'menu_slug'   => $optionType . ucfirst($optionCategory['name']) . $subPageName
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
        'fields' => $fields,
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
}
