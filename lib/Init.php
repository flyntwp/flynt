<?php

namespace Flynt\Init;

require_once __DIR__ . '/Utils/FileLoader.php';

use Flynt;
use Flynt\Utils\Asset;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

FileLoader::loadPhpFiles('lib/Utils');

function initTheme()
{
    // initialize plugin defaults
    Flynt\initDefaults();

    // Set to true to load all assets from a CDN if there is one specified
    Asset::loadFromCdn(false);

    add_theme_support('flynt-youtube-no-cookie-embed');

    // register all components in 'Components' folder
    add_theme_support('flynt-components', get_template_directory() . '/dist/Components/');

    // register all custom post types
    add_theme_support('flynt-custom-post-types', [
        'dir' => get_template_directory() . '/config/customPostTypes/',
        'fileName' => 'config.json'
    ]);

    // register all custom taxonomies
    add_theme_support('flynt-custom-taxonomies', [
        'dir' => get_template_directory() . '/config/customTaxonomies/'
    ]);

    // initialize ACF Field Groups and Option Pages
    add_theme_support('flynt-acf', [
        'FieldLoader',
        'FieldGroupComposer',
        'OptionPages',
        'FlexibleContentToggle',
        'GoogleMaps'
    ]);

    // enable admin notices
    add_theme_support('flynt-admin-notices');

    // set correct config dir (+ more?)
    add_theme_support('flynt-templates');

    // use timber rendering
    add_theme_support('flynt-timber-loader');

    // load jQuery in footer by default
    add_theme_support('flynt-jquery');

    // clean up some things
    add_theme_support('flynt-clean-head');
    add_theme_support('flynt-clean-rss');
    add_theme_support('flynt-mime-types');
    add_theme_support('flynt-remove-editor');
    add_theme_support('flynt-tiny-mce');
    add_theme_support('flynt-base-style');

    // add components previews
    add_theme_support('flynt-admin-component-preview');

    // google analytics
    add_theme_support('flynt-google-analytics');

    // hide protected posts
    add_theme_support('flynt-hide-protected-posts');

    // move yoast seo plugin box to the bottom of the backend interface
    add_theme_support('flynt-yoast-to-bottom');

    // WP Stuff
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

    add_theme_support('flynt-password-form');
    add_theme_support('flynt-external-script-loader');
    add_theme_support('flynt-lodash');
    add_theme_support('flynt-component-log-server');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');

function loadFeatures()
{
    $basePath = get_template_directory() . '/dist/Features';

    if (!is_dir($basePath)) {
        trigger_error(
            "Failed loading Features! {$basePath} does not exist! Did you run `flynt start` yet?",
            E_USER_WARNING
        );
        return;
    }

    // Filter out other (non-flynt) theme features
    $flyntThemeFeatures = array_filter($GLOBALS['_wp_theme_features'], function ($feature) {
        return StringHelpers::startsWith('flynt-', $feature);
    }, ARRAY_FILTER_USE_KEY);

    foreach ($flyntThemeFeatures as $feature => $options) {
        Feature::register($feature, $basePath, $options);
    }

    do_action('Flynt/afterRegisterFeatures');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\loadFeatures', 100);
