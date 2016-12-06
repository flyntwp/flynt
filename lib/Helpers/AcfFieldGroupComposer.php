<?php

namespace WPStarterTheme\Helpers;

use RecursiveDirectoryIterator;
use ACFComposer\ACFComposer;
use WPStarterTheme\Helpers\Utils;
use WPStarterTheme\Core;

class ACFFieldGroupComposer {
  const FILTER_NAMESPACE = 'WPStarterTheme/Modules';
  const FIELD_GROUPS_DIR = '/config/fieldGroups';

  protected static $fieldGroupsLoaded = false;

  public static function init() {
    $acfEnabled = class_exists('acf');
    $acfFunctionsExist = function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page');
    $acfComposerEnabled = class_exists('ACFComposer\ACFComposer');

    if ($acfEnabled && $acfFunctionsExist && $acfComposerEnabled) {
      add_action(
        'WPStarter/registerModule',
        ['WPStarterTheme\Helpers\ACFFieldGroupComposer', 'addFieldFilters'],
        11,
        2
      );

      add_action(
        'acf/init',
        ['WPStarterTheme\Helpers\ACFFieldGroupComposer', 'loadFieldGroups']
      );
    } else {
      $msg = '';

      // TODO refactor this functionality into Core Utility Class?
      if (!$acfEnabled) {
        $msg .= '<p>Advanced Custom Fields Plugin not installed or activated.'
        . ' Make sure you <a href="'
        . esc_url(admin_url('plugins.php')) . '">'
        . 'install / activate the plugin.</a></p>';
      } elseif (!$acfFunctionsExist) {
        $msg .= '<p>Advanced Custom Fields Plugin Functions not found!'
        . ' Please make sure you are using the latest version of ACF.</p>';
      }

      if (!$acfComposerEnabled) {
        $msg .= '<p>ACF Composer Plugin not installed or activated.'
        . ' Make sure you <a href="'
        . esc_url(admin_url('plugins.php')) . '">'
        . 'install / activate the plugin.</a></p>';
      }

      add_action('admin_notices', function () use ($msg) {
        $msg .= '<p><i>To resolve this issue either follow the steps above'
          . ' or remove the Helpers requiring this functionality in your theme.</i></p>';
        echo '<div class="notice is-dismissible"><p><strong>Could not create ACF Field Groups</strong></p>'
          . $msg . '</div>';
      });
    }
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

    Core::iterateDirectory($dir, function ($file) {
      if ($file->getExtension() === 'json') {
        $filePath = $file->getPathname();
        $config = json_decode(file_get_contents($filePath), true);
        ACFComposer::registerFieldGroup($config);
      }
    });

    self::$fieldGroupsLoaded = true;
  }

  public static function addFieldFilters($modulePath, $moduleName) {
    // load fields.json if it exists
    $filePath = $modulePath . '/fields.json';
    if(!is_file($filePath)) return;
    $fields = json_decode(file_get_contents($filePath), true);

    // make sure naming convention is kept
    $moduleName = ucfirst($moduleName);

    // add filters
    foreach ($fields as $groupKey => $groupValue) {
      $groupKey = ucfirst($groupKey);
      $filterName = self::FILTER_NAMESPACE . "/{$moduleName}/{$groupKey}";

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
