<?php

// TODO make global fields untranslatable
// TODO add sub pages for Features

namespace Flynt\Features\Acf;

use ACFComposer;
use Flynt\ComponentManager;
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

  public static function init() {
    self::createOptionPages();

    // Components
    // if (array_key_exists('component', self::OPTION_CATEGORIES)) {
      add_action(
        'Flynt/registerComponent',
        ['Flynt\Features\Acf\OptionPages', 'addAllComponentSubPages'],
        12
      );
    // }

    // Custom Post Types
    // if (array_key_exists('customPostType', self::OPTION_CATEGORIES)) {
      self::addAllCustomPostTypeSubPages();
    // }

    // Features


    // add styles for admin area
    add_action('admin_enqueue_scripts', function () {
      Component::addAsset('enqueue', [
        'type' => 'style',
        'name' => 'ACF/AdminCSS',
        'path' => 'Features/Acf/admin.css'
      ]);
    });

    // add_filter('Flynt/addComponentData', function ($data, $componentName) {
    //   // $data[] =
    // });

    // self::removeEmptyOptionPages();
  }

  public static function createOptionPages() {
    foreach (self::OPTION_TYPES as $optionType => $option) {
      $title = $option['title'];
      $slug = ucfirst($optionType);

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

  public static function addAllComponentSubPages($componentName) {
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

  protected static function addAllCustomPostTypeSubPages() {
    if (!Feature::isActive('flynt-custom-post-types')) {
      // TODO add Admin Notice
      return;
    }

    // load fields.json files
    $dir = Feature::getOptions('flynt-custom-post-types')[0]['directory'];
    FileLoader::iterateDirectory($dir, function ($cptDir) {
      if ($cptDir->isDir()) {
        $cptConfig = CustomPostTypeRegister::getRegistered($cptDir->getFilename());
        $filePath = $cptDir->getPathname() . '/fields.json';

        if (is_file($filePath)) {
          // TODO refactor
          $cptName = ucfirst($cptDir->getFilename());
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
          self::createSubPageFromConfig($filePath, 'customPostType', $cptName);
        }
      }
    });
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
