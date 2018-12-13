<?php

namespace Flynt;

use Flynt\Utils\FileLoader;
use Flynt\Bootstrap;

require_once __DIR__ . '/inc/Bootstrap.php';

// This needs to happen first.
// Reason:  In case the theme was just activated and the plugin is not active,
//          we still need to run the after_switch_theme action, which is
//          defined here.
Bootstrap::setTemplateDirectory();

require_once __DIR__ . '/inc/Utils/FileLoader.php';
FileLoader::loadPhpFiles('inc/Core');
// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Bootstrap::checkRequiredPlugins()) {
    FileLoader::loadPhpFiles('inc/Utils');
    FileLoader::loadPhpFiles('inc');
}
