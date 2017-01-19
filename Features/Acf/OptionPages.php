<?php

// TODO make global fields untranslatable
// TODO add sub pages for CPTs and Features as well and prefix all of them

namespace Flynt\Features\Acf;

use Flynt\ComponentManager;
use Flynt\Utils\StringHelpers;
use Flynt\Features\Components\Component;
use ACFComposer;

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
    ]
  ];

  protected static $optionPages = [];

  public static function init() {
    self::createOptionPages();

    add_action(
      'Flynt/registerComponent',
      ['Flynt\Features\Acf\OptionPages', 'addAllComponentSubPages'],
      12
    );

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

  public static function addAllComponentSubPages($componentName) {
    // load fields.json if it exists
    $componentManager = ComponentManager::getInstance();
    $filePath = $componentManager->getComponentFilePath($componentName, 'fields.json');

    if (false === $filePath) {
      return;
    }

    self::createSubPageFromConfig($filePath, 'component', $componentName);
  }

  protected static function createSubPageFromConfig($filePath, $optionCategory, $subPageName) {
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::OPTION_TYPES as $optionType => $option) {
      if (array_key_exists($option['name'], $fields)) {
        self::addOptionSubPage(
          self::OPTION_CATEGORIES[$optionCategory],
          $subPageName,
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
