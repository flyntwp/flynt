<?php

namespace Flynt\Init;

// TODO refactor this utils loading
require_once __DIR__ . '/Utils/StringHelpers.php';
require_once __DIR__ . '/Utils/DomNode.php';

use Flynt;
use Flynt\Utils\StringHelpers;

// @codingStandardsIgnoreLine
function initTheme() {
  // initialize plugin defaults
  Flynt\initDefaults();

  // register all custom post types
  add_theme_support('flynt-custom-post-types', get_template_directory() . '/config/customPostTypes/');

  // enable admin notices
  add_theme_support('flynt-admin-notices');

  // initialize ACF Field Groups and Option Pages
  add_theme_support('flynt-acf', [
    'FieldGroupComposer',
    'OptionPages'
  ]);

  // register all components in 'Components' folder
  add_theme_support('flynt-components');

  // set correct config dir (+ more?)
  add_theme_support('flynt-templates');

  // use timber rendering
  add_theme_support('flynt-timber');

  // more stuff
  add_theme_support('flynt-clean-up');
  add_theme_support('flynt-jquery');
  add_theme_support('flynt-mime-types');
  add_theme_support('flynt-navigation');

  // WP Stuff
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');

// @codingStandardsIgnoreLine
function loadModules() {
  // @codingStandardsIgnoreLine
  global $_wp_theme_features;
  foreach (glob(__DIR__ . '/Features/*', GLOB_ONLYDIR) as $dir) {
    $feature = 'flynt-' . StringHelpers::camelCaseToKebap(basename($dir));
    // @codingStandardsIgnoreLine
    if (isset($_wp_theme_features[$feature])) {
      // TODO get this option passing working
      // Options::init($feature, $_wp_theme_features[$feature]);
      $file = $dir . '/functions.php';
      if (is_file($file)) require_once $file;
    }
  }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\loadModules', 100);
