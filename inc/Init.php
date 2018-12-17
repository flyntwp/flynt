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

    global $flyntCurrentOptionCategory;
    $flyntCurrentOptionCategory = 'feature';

    Feature::register('YoutubeNoCookieEmbed', $basePath);

    // initialize ACF Field Groups and Option Pages
    Feature::register('Acf', $basePath, [[
        'FlexibleContentToggle',
        'GoogleMaps'
    ]]);

    // enable admin notices
    Feature::register('AdminNotices', $basePath);

    // use timber rendering
    Feature::register('TimberLoader', $basePath);

    // load jQuery in footer by default
    Feature::register('Jquery', $basePath);

    // clean up some things
    Feature::register('CleanHead', $basePath);
    Feature::register('CleanRss', $basePath);
    Feature::register('MimeTypes', $basePath);
    Feature::register('RemoveEditor', $basePath);
    Feature::register('TinyMce', $basePath);
    Feature::register('BaseStyle', $basePath);

    // add components previews
    Feature::register('AdminComponentPreview', $basePath);

    // google analytics
    Feature::register('GoogleAnalytics', $basePath);

    // hide protected posts
    Feature::register('HideProtectedPosts', $basePath);

    // move yoast seo plugin box to the bottom of the backend interface
    Feature::register('YoastToBottom', $basePath);

    Feature::register('PasswordForm', $basePath);
    Feature::register('ExternalScriptLoader', $basePath);
    Feature::register('Lodash', $basePath);
    Feature::register('ComponentLogServer', $basePath);

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
