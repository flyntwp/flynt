<?php

namespace Flynt\Helpers\Acf;

use Flynt\Helpers\StringHelpers;
use ACFComposer;

class OptionPages {
  const FILTER_NAMESPACE = 'Flynt/Components';
  const FIELD_GROUPS_DIR = '/config/fieldGroups';

  const OPTION_TYPES = [
    'options',
    'localeOptions'
  ];

  protected static $optionPages = [];

  public static function init() {
    self::createOptionPages();

    add_action(
      'Flynt/registerComponent',
      ['Flynt\Helpers\Acf\OptionPages', 'addAllComponentOptionSubpages'],
      12,
      2
    );
  }

  public static function createOptionPages() {
    foreach (self::OPTION_TYPES as $index => $optionType) {
      $title = ucfirst($optionType);
      $slug = 'component' . ucfirst($optionType);

      $generalSettings = acf_add_options_page(array(
        'page_title'  => 'Component ' . $title,
        'menu_title'  => $title,
        'redirect'    => false,
        'menu_slug'   => $slug
      ));

      self::$optionPages[$optionType] = [
        'menu_slug' => $slug
      ];
    }
  }

  public static function setOptionSubPageFieldGroupConfig($parentMenuSlug, $menuSlug, $prettyComponentName, $fields) {
    $fieldGroup = ACFComposer\ResolveConfig::forFieldGroup(
      [
        'name' => 'options' . ucfirst($parentMenuSlug) . $menuSlug,
        'title' => $prettyComponentName,
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

  public static function addComponentOptionSubpages($componentPath, $componentName, $optionType, $fields) {
    $prettyComponentName = StringHelpers::splitCamelCase($componentName);

    $componentConfig = array(
      'page_title'  =>  $prettyComponentName. ' Component',
      'menu_title'  => $prettyComponentName,
      'parent_slug' => self::$optionPages[$optionType]['menu_slug'],
      'menu_slug'   => $optionType. 'Component' . $componentName
    );

    acf_add_options_sub_page($componentConfig);

    self::setOptionSubPageFieldGroupConfig(
      $componentConfig['parent_slug'],
      $componentConfig['menu_slug'],
      $componentConfig['menu_title'],
      $fields
    );
  }

  public static function addAllComponentOptionSubpages($componentPath, $componentName) {
    // load fields.json if it exists
    $filePath = $componentPath . '/fields.json';
    if (!is_file($filePath)) return;
    $fields = json_decode(file_get_contents($filePath), true);

    foreach (self::OPTION_TYPES as $index => $optionType) {
      if (array_key_exists($optionType, $fields)) {
        self::addComponentOptionSubpages($componentPath, $componentName, $optionType, $fields[$optionType]);
      }
    }
  }
}
