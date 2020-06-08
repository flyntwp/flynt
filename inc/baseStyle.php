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

function setDocumentTitle()
{
    // prevent yoast overwriting the title
    add_filter('pre_get_document_title', function ($title) {
        return '';
    }, 99);

    // set custom title and keep the default separator and site name
    add_filter('document_title_parts', function ($title) {
        $title['title'] = 'Base Style';
        return $title;
    }, 99);
}

function templateInclude($template)
{
    global $wp_query;

    if (isset($wp_query->query_vars[ROUTENAME])) {
        setDocumentTitle();
        add_action('wp_head', 'wp_no_robots');
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}
