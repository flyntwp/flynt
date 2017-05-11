<?php

namespace Flynt;

require_once __DIR__ . '/lib/Bootstrap.php';

use Flynt\Bootstrap;

// This needs to happen first.
// Reason:  In case the theme was just activated and the plugin is not active,
//          we still need to run the after_switch_theme action, which is
//          defined here.
Bootstrap::setTemplateDirectory();

// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Bootstrap::checkRequiredPlugins()) {
    require_once get_template_directory() . '/lib/Init.php';
}
