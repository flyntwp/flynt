<?php

namespace Flynt\Features\BaseStyle;

use Timber\Timber;
use Flynt\ComponentManager;

if (current_user_can('editor') || (WP_ENV !== 'production')) {
    add_filter('init', 'Flynt\Features\BaseStyle\registerRewriteRule');
    add_filter('template_include', 'Flynt\Features\BaseStyle\templateInclude');
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
    $routeName = \Flynt\Features\BaseStyle\ROUTENAME;

    add_rewrite_rule("{$routeName}/?(.*?)/?$", "index.php?{$routeName}=\$matches[1]", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");

    $rules = get_option('rewrite_rules');

    if (! isset($rules["{$routeName}/(.*?)/?$"])) {
        flush_rewrite_rules();
    }
}

function templateInclude($template)
{
    $routeName = \Flynt\Features\BaseStyle\ROUTENAME;
    global $wp_query;

    if (isset($wp_query->query_vars['BaseStyle'])) {
        return __DIR__ . '/template.php';
    }

    return $template;
}
