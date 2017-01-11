<?php

namespace Flynt\Init;

require_once __DIR__ . '/Utils/FileLoader.php';

use Flynt;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

FileLoader::loadPhpFiles('lib/Utils');

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

  // clean up some things
  add_theme_support('flynt-clean-head');
  add_theme_support('flynt-clean-rss');
  add_theme_support('flynt-jquery');
  add_theme_support('flynt-mime-types');
  add_theme_support('flynt-navigation');
  add_theme_support('flynt-remove-editor');
  add_theme_support('flynt-tiny-mce');

  // google analytics
  add_theme_support('flynt-google-analytics');

  // WP Stuff
  add_theme_support('post-thumbnails');
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');

// @codingStandardsIgnoreLine
function loadFeatures() {
  global $_wp_theme_features; // @codingStandardsIgnoreLine
  foreach (glob(__DIR__ . '/Features/*', GLOB_ONLYDIR) as $dir) {
    $feature = 'flynt-' . StringHelpers::camelCaseToKebap(basename($dir));
    if (isset($_wp_theme_features[$feature])) { // @codingStandardsIgnoreLine
      Feature::init($feature, $dir, $_wp_theme_features[$feature]);
    }
  }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\loadFeatures', 100);
