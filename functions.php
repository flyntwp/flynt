<?php

namespace Flynt;

use Flynt\Utils\FileLoader;

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('WP_ENV')) {
    define('WP_ENV', 'production');
}

// Check if the required plugins are installed and activated.
// If they aren't, this function redirects the template rendering to use
// plugin-inactive.php instead and shows a warning in the admin backend.
if (Init::checkRequiredPlugins()) {
    FileLoader::loadPhpFiles('inc');
    add_action('after_setup_theme', ['Flynt\Init', 'initTheme']);
    add_action('after_setup_theme', ['Flynt\Init', 'loadComponents'], 101);
}

// Remove the admin-bar inline-CSS as it isn't compatible with the sticky footer CSS.
// This prevents unintended scrolling on pages with few content, when logged in.
add_theme_support('admin-bar', array('callback' => '__return_false'));

add_action('after_setup_theme', function () {
    /**
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain('flynt', get_template_directory() . '/languages');
});


// Add rules to .htaccess to restrict access to .twig files on theme setup.
add_action('after_setup_theme', function () {
    add_filter('mod_rewrite_rules', ['Flynt\Init', 'addTwigRestrictionRules']);
});
// Remove twig restriction rules from .htaccess on theme switch.
add_action('switch_theme', function () {
    remove_filter('mod_rewrite_rules', ['Flynt\Init', 'addTwigRestrictionRules']);
    flush_rewrite_rules();
});
