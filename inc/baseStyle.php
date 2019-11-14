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

    add_rewrite_rule("{$routeName}/?(.*?)/?$", "index.php?{$routeName}=\$matches[1]", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");

    $rules = get_option('rewrite_rules');

    if (! isset($rules["{$routeName}/(.*?)/?$"])) {
        flush_rewrite_rules();
    }
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

    if (isset($wp_query->query_vars['BaseStyle'])) {
        disallowRobots();
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}
