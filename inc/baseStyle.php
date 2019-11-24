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

    add_rewrite_rule("{$routeName}/?$", "index.php?{$routeName}", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");
}

function templateInclude($template)
{
    global $wp_query;

    if (isset($wp_query->query_vars[ROUTENAME])) {
        add_action('wp_head', 'wp_no_robots');
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}
