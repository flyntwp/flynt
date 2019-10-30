<?php

/**
 * Loads a `basestyle.php` template to render base style markup for proper base styling, if user is on non-production environment or has edit rights at least.
 *
 * Example usage:
 * 1. Log into your WordPress Backend with an Administrator account.
 * 2. Navigate your browser to `/BaseStyle/`.
 */

namespace Flynt\BaseStyle;

if (current_user_can('editor') || (WP_ENV !== 'production')) {
    add_filter('init', 'Flynt\BaseStyle\registerRewriteRule');
    add_filter('template_include', 'Flynt\BaseStyle\templateInclude');
    disallowRobots();
}

const ROUTENAME = 'BaseStyle';

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

function templateInclude($template)
{
    global $wp_query;

    if (isset($wp_query->query_vars['BaseStyle'])) {
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}
