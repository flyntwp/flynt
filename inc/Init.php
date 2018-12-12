<?php

namespace Flynt\Init;

require_once __DIR__ . '/Utils/FileLoader.php';

use Flynt;
use Flynt\Utils\Asset;
use Flynt\Utils\Feature;
use Flynt\Utils\FileLoader;
use Flynt\Utils\StringHelpers;

FileLoader::loadPhpFiles('inc/Utils');

add_action('after_setup_theme', __NAMESPACE__ . '\\initTheme');
add_action('after_setup_theme', __NAMESPACE__ . '\\loadFeatures', 100);

function initTheme()
{
    // initialize plugin defaults
    Flynt\initDefaults();

    // Set to true to load all assets from a CDN if there is one specified
    Asset::loadFromCdn(false);

    // WP Stuff
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));
}

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

    Feature::register('flynt-youtube-no-cookie-embed', $basePath);

    // register all components in 'Components' folder
    Feature::register('flynt-components', $basePath, [get_template_directory() . '/dist/Components/']);

    // register all custom post types
    Feature::register('flynt-custom-post-types', $basePath, [[
        'dir' => get_template_directory() . '/config/customPostTypes/',
        'fileName' => 'config.json'
    ]]);

    // register all custom taxonomies
    Feature::register('flynt-custom-taxonomies', $basePath, [[
        'dir' => get_template_directory() . '/config/customTaxonomies/'
    ]]);

    // initialize ACF Field Groups and Option Pages
    Feature::register('flynt-acf', $basePath, [[
        'FieldLoader',
        'FieldGroupComposer',
        'OptionPages',
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

    do_action('Flynt/afterRegisterFeatures', $basePath);
}
