<?php

/**
 * Registers a custom rewrite rule and template for the 'BaseStyle' route.
 * The route can be accessed at /BaseStyle/ in the site's permalink structure.
 * The template file used for this route is 'basestyle.php' in the theme's root directory.
 * The document title for this route is set to 'Base Style'.
 */

namespace Flynt\BaseStyle;

const ROUTENAME = 'BaseStyle';

add_filter('init', 'Flynt\BaseStyle\registerRewriteRule');
add_filter('template_include', 'Flynt\BaseStyle\templateInclude');

/**
 * Registers the custom rewrite rule for the 'BaseStyle' route.
 */
function registerRewriteRule()
{
    $routeName = ROUTENAME;

    add_rewrite_rule("{$routeName}/?$", "index.php?{$routeName}", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");
}

/**
 * Sets the template file for the 'BaseStyle' route and sets the document title for the route.
 *
 * @param string $template The current template file path.
 * @return string The template file path to use for the 'BaseStyle' route.
 */
function templateInclude($template)
{
    global $wp_query;

    if (isset($wp_query->query_vars[ROUTENAME])) {
        setDocumentTitle();
        add_filter('wp_robots', 'wp_robots_no_robots');
        return get_template_directory() . '/basestyle.php';
    }

    return $template;
}

/**
 * Sets the document title for the 'BaseStyle' route.
 */
function setDocumentTitle()
{
    // prevent yoast overwriting the title
    add_filter('pre_get_document_title', '__return_empty_string', 99);

    // set custom title and keep the default separator and site name
    add_filter('document_title_parts', function ($title) {
        $title['title'] = __('Base Style', 'flynt');
        return $title;
    }, 99);
}
