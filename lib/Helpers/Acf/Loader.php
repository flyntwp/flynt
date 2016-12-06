<?php

namespace WPStarterTheme\Helpers\Acf;

use WPStarterTheme\Helpers\AdminNoticeManager;

class Loader {

  public static function init($helpers = []) {
    if (empty($helpers)) return;

    $requirements = self::checkRequirements();

    // are all requirements met?
    if (!in_array(false, $requirements, true)) {

      self::initHelpers($helpers);

    } elseif (class_exists('WPStarterTheme\Helpers\AdminNoticeManager')) {

      self::showAdminNotice($requirements, $helpers);

    }
  }

  protected static function checkRequirements() {
    return [
      'acfEnabled' => class_exists('acf'),
      'acfFunctionsExist' => function_exists('acf_add_options_page') && function_exists('acf_add_options_sub_page'),
      'acfComposerEnabled' => class_exists('ACFComposer\ACFComposer'),
    ];
  }

  protected static function initHelpers($helpers) {
    $namespacePrefix = 'WPStarterTheme\Helpers\Acf';
    foreach ($helpers as $helperName) {
      $className = "{$namespacePrefix}\\$helperName";
      if (class_exists($className) && method_exists($className, 'init')) {
        $className::init();
      }
    }
  }

  protected static function showAdminNotice($requirements, $helpers) {
    $messages = [];

    if (!$requirements['acfEnabled']) {
      $messages[] = 'Advanced Custom Fields Plugin not installed or activated. Make sure you <a href="'
        . esc_url(admin_url('plugins.php')) . '">install or activate the plugin</a>.';
    } elseif (!$requirements['acfFunctionsExist']) {
      $messages[] = 'Advanced Custom Fields Plugin Functions not found! Please make sure you are using'
        . ' the latest version of ACF.';
    }

    if (!$requirements['acfComposerEnabled']) {
      $messages[] = 'ACF Composer Plugin not installed or activated. Make sure you <a href="'
        . esc_url(admin_url('plugins.php')) . '">install or activate the plugin</a>.';
    }

    $manager = AdminNoticeManager::getInstance();
    $manager->addNotice($messages, [
      'title' => 'Could not initialize ACF Helpers (' . implode(', ', $helpers) . ')',
      'type' => 'warning',
      'dismissible' => true,
      'filenames' => basename(__DIR__)
    ]);
  }
}
