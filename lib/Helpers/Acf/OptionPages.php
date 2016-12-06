<?php

namespace WPStarterTheme\Helpers\Acf;

use WPStarterTheme\Helpers\StringHelpers;
use ACFComposer;

class OptionPages {
  const FILTER_NAMESPACE = 'WPStarterTheme/Modules';
  const FIELD_GROUPS_DIR = '/config/fieldGroups';

  const OPTION_TYPES = [
    'options',
    'localeOptions'
  ];

  protected static $optionPages = [];

  public static function init() {
    self::createOptionPages();

    add_action(
      'WPStarter/registerModule',
      ['WPStarterTheme\Helpers\Acf\OptionPages', 'addAllModuleOptionSubpages'],
      12,
      2
    );
  }

  public static function createOptionPages() {
    foreach (self::OPTION_TYPES as $index => $optionType) {
      $title = ucfirst($optionType);
      $slug = 'module' . ucfirst($optionType);

      $generalSettings = acf_add_options_page(array(
        'page_title'  => 'Module ' . $title,
        'menu_title'  => $title,
        'redirect'    => false,
        'menu_slug'   => $slug
      ));

      self::$optionPages[$optionType] = [
        'menu_slug' => $slug
      ];
    }
  }

  public static function setOptionSubPageFieldGroupConfig($parentMenuSlug, $menuSlug, $prettyModuleName, $fields) {
    $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
      [
        'name' => 'options' . ucfirst($parentMenuSlug) . $menuSlug,
        'title' => $prettyModuleName,
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

  public static function addModuleOptionSubpages($modulePath, $moduleName, $optionType, $fields) {
    $prettyModuleName = StringHelpers::splitCamelCase($moduleName);

    $moduleConfig = array(
      'page_title'  =>  $prettyModuleName. ' Module',
      'menu_title'  => $prettyModuleName,
      'parent_slug' => self::$optionPages[$optionType]['menu_slug'],
      'menu_slug'   => $optionType. 'Module' . $moduleName
    );

    acf_add_options_sub_page($moduleConfig);

    self::setOptionSubPageFieldGroupConfig(
      $moduleConfig['parent_slug'],
      $moduleConfig['menu_slug'],
      $moduleConfig['menu_title'],
      $fields
    );
  }

  public static function addAllModuleOptionSubpages($modulePath, $moduleName) {
    // load fields.json if it exists
    $filePath = $modulePath . '/fields.json';
    if (!is_file($filePath)) return;
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::OPTION_TYPES as $index => $optionType) {
      if (array_key_exists($optionType, $fields)) {
        self::addModuleOptionSubpages($modulePath, $moduleName, $optionType, $fields[$optionType]);
      }
    }
  }
}
