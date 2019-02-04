<?php

namespace Flynt;

use Flynt\Utils\FileLoader;
use Flynt\Bootstrap;

require_once __DIR__ . '/vendor/autoload.php';

// This needs to happen first.
// Reason:  In case the theme was just activated and the plugin is not active,
//          we still need to run the after_switch_theme action, which is
//          defined here.
Init::setTemplateDirectory();

// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Init::checkRequiredPlugins()) {
    FileLoader::loadPhpFiles('inc');
}

add_action('after_setup_theme', ['Flynt\Init', 'initTheme']);
add_action('after_setup_theme', ['Flynt\Init', 'loadFeatures'], 100);
add_action('after_setup_theme', ['Flynt\Init', 'loadComponents'], 101);
