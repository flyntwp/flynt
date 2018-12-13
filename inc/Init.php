<?php

namespace Flynt\Init;

use Flynt;
use Flynt\Utils\Asset;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;
use Timber\Timber;

add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');
add_action('after_setup_theme', __NAMESPACE__ . '\\loadFeatures', 100);
add_action('after_setup_theme', __NAMESPACE__ . '\\loadComponents', 101);

function initTheme()
{
    // initialize plugin defaults
    Flynt\initDefaults();

    // Set to true to load all assets from a CDN if there is one specified
    Asset::loadFromCdn(false);

    // WP Stuff
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    new Timber();
}

function loadFeatures()
{
    $basePath = get_template_directory() . '/dist/Features';

    Feature::register('flynt-youtube-no-cookie-embed', $basePath);

    // initialize ACF Field Groups and Option Pages
    Feature::register('flynt-acf', $basePath, [[
        'FlexibleContentToggle',
        'GoogleMaps'
    ]]);

    // enable admin notices
    Feature::register('flynt-admin-notices', $basePath);

    // use timber rendering
    Feature::register('flynt-timber-loader', $basePath);

    // load jQuery in footer by default
    Feature::register('flynt-jquery', $basePath);

    // clean up some things
    Feature::register('flynt-clean-head', $basePath);
    Feature::register('flynt-clean-rss', $basePath);
    Feature::register('flynt-mime-types', $basePath);
    Feature::register('flynt-remove-editor', $basePath);
    Feature::register('flynt-tiny-mce', $basePath);
    Feature::register('flynt-base-style', $basePath);

    // add components previews
    Feature::register('flynt-admin-component-preview', $basePath);

    // google analytics
    Feature::register('flynt-google-analytics', $basePath);

    // hide protected posts
    Feature::register('flynt-hide-protected-posts', $basePath);

    // move yoast seo plugin box to the bottom of the backend interface
    Feature::register('flynt-yoast-to-bottom', $basePath);

    Feature::register('flynt-password-form', $basePath);
    Feature::register('flynt-external-script-loader', $basePath);
    Feature::register('flynt-lodash', $basePath);
    Feature::register('flynt-component-log-server', $basePath);

    do_action('Flynt/afterRegisterFeatures');
}

function loadComponents()
{
    $basePath = get_template_directory() . '/dist/Components';
    global $flyntCurrentOptionCategory;
    $flyntCurrentOptionCategory = 'component';
    Flynt\registerComponentsFromPath($basePath);
    do_action('Flynt/afterRegisterComponents');
}
