<?php

namespace Flynt;

require_once __DIR__ . '/lib/Bootstrap.php';

use Flynt\Bootstrap;

// This needs to happen first.
// Reason:  In case the theme was just activated and the plugin is not active,
//          we still need to run the after_switch_theme action, which is
//          defined here.
Bootstrap::setTemplateDirectory();

// Check if the plugin is installed and activated.
// If it isn't, this function redirects the template rendering to use
// plugin-inactive.php instead
if (Bootstrap::checkPlugin()) {
    require_once get_template_directory() . '/lib/Init.php';
}
