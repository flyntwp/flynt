<?php

namespace Flynt\Features\Acf;

// TODO refactor this util loading
require_once dirname(dirname(__DIR__)) . '/Utils/Utils.php';
require_once dirname(dirname(__DIR__)) . '/Utils/FileLoader.php';

use RecursiveDirectoryIterator;
use ACFComposer\ACFComposer;
use Flynt\Utils\Utils;
use Flynt\Utils\FileLoader;
use Flynt\ComponentManager;

class FieldGroupComposer {
  const FILTER_NAMESPACE = 'Flynt/Components';
  const FIELD_GROUPS_DIR = '/config/fieldGroups';

  protected static $fieldGroupsLoaded = false;

  public static function init() {
    add_action(
      'Flynt/registerComponent',
      ['Flynt\Features\Acf\FieldGroupComposer', 'addFieldFilters'],
      11
    );

    add_action(
      'acf/init',
      ['Flynt\Features\Acf\FieldGroupComposer', 'loadFieldGroups']
    );
  }

  public static function loadFieldGroups() {
    // prevent this running more than once
    if (self::$fieldGroupsLoaded) return;

    // Load field groups from files after ACF initializes
    $dir = get_template_directory() . self::FIELD_GROUPS_DIR;

    if (!is_dir($dir)) {
      trigger_error("[ACF] Cannot load field groups: {$dir} is not a valid directory!", E_USER_WARNING);
      return;
    }

    FileLoader::iterateDirectory($dir, function ($file) {
      if ($file->getExtension() === 'json') {
        $filePath = $file->getPathname();
        $config = json_decode(file_get_contents($filePath), true);
        ACFComposer::registerFieldGroup($config);
      }
    });

    self::$fieldGroupsLoaded = true;
  }

  public static function addFieldFilters($componentName) {
    // load fields.json if it exists
    $componentManager = ComponentManager::getInstance();
    $filePath = $componentManager->getComponentFilePath($componentName, 'fields.json');

    if (false === $filePath) {
      return;
    }

    $fields = json_decode(file_get_contents($filePath), true);

    // make sure naming convention is kept
    $componentName = ucfirst($componentName);

    // add filters
    foreach ($fields as $groupKey => $groupValue) {
      $groupKey = ucfirst($groupKey);
      $filterName = self::FILTER_NAMESPACE . "/{$componentName}/{$groupKey}";

      add_filter($filterName, function ($config) use ($groupValue) {
        return $groupValue;
      });
      if (Utils::isAssoc($groupValue) && array_key_exists('sub_fields', $groupValue)) {
        $filterName .= '/SubFields';
        $subFields = $groupValue['sub_fields'];

        add_filter($filterName, function ($subFieldsconfig) use ($subFields) {
          return $subFields;
        });
        self::addFilterForSubFields($filterName, $subFields);
      } elseif (is_array($groupValue)) {
        self::addFilterForSubFields($filterName, $groupValue);
      }
    }
  }

  protected static function addFilterForSubFields($parentFilterName, $subFields) {
    foreach ($subFields as $subField) {
      if (!array_key_exists('name', $subField)) {
        trigger_error('[ACF] Name is missing in Sub Field while adding Filter: ' . $parentFilterName, E_USER_WARNING);
        continue;
      }
      $subFieldName = ucfirst($subField['name']);
      $subFilterName = $parentFilterName . "/{$subFieldName}";

      add_filter($subFilterName, function ($subFieldConfig) use ($subField) {
        return $subField;
      });
    }
  }
}
