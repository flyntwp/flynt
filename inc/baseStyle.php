<?php

/**
 * Loads the `basestyle.php` template on route /BaseStyle/ to render base style markup for proper base styling.
 */

namespace Flynt\BaseStyle;

add_filter('init', 'Flynt\BaseStyle\registerRewriteRule');
add_filter('template_include', 'Flynt\BaseStyle\templateInclude');

const ROUTENAME = 'BaseStyle';

function registerRewriteRule()
{
    $routeName = ROUTENAME;
    $routeString = "{$routeName}/?(.*?)/?$";

    add_rewrite_rule($routeString, "index.php?{$routeName}=\$matches[1]", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");
}

function disallowRobots()
{
    if (defined('WPSEO_VERSION')) {
        add_filter('wpseo_robots', function () {
            return "noindex,nofollow";
        });
    } else {
        remove_action('wp_head', 'noindex', 1);
        add_action('wp_head', function () {
            echo "<meta name='robots' content='noindex,nofollow' />\n";
        });
    }
}

function templateInclude($template)
{
    global $wp_query;

    if (isset($wp_query->query_vars[ROUTENAME])) {
        disallowRobots();
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}
