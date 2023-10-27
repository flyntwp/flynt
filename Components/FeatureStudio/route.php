<?php

/**
 * Registers a custom rewrite rule and template for the 'BaseStyle' route.
 * The route can be accessed at /BaseStyle/ in the site's permalink structure.
 * The template file used for this route is 'basestyle.php' in the theme's root directory.
 * The document title for this route is set to 'Base Style'.
 */

namespace Flynt\Renderer;

const ROUTE_NAME = 'renderer';

/**
 * Registers the custom rewrite rule for the 'BaseStyle' route.
 */
add_action('init', function () {
    $routeName = ROUTE_NAME;

    add_rewrite_rule("{$routeName}/?$", "index.php?pagename={$routeName}", "top");
    add_rewrite_tag("%{$routeName}%", "([^&]+)");
});
/**
 * Sets the template file for the 'BaseStyle' route and sets the document title for the route.
 */
add_filter('template_include', function ($template) {
    global $wp_query;

    $routeName = ROUTE_NAME;

    if (isset($wp_query->query['pagename']) && $wp_query->query["pagename"] === $routeName) {
        setDocumentTitle();
        add_filter('wp_robots', 'wp_robots_no_robots');
        add_action('parse_query', function ($query) {
            if ($query->is_main_query()) {
                $query->is_404 = false;
            }
        }, 1);
        add_action('template_redirect', function () {
            global $wp_query;
            $wp_query->is_404 = false;
        });
        return get_template_directory() . '/Components/FeatureStudio/renderer.php';
    }

    return $template;
});
/**
 * Sets the document title for the 'BaseStyle' route.
 */
function setDocumentTitle()
{
    // prevent yoast overwriting the title
    add_filter('pre_get_document_title', '__return_empty_string', 99);

    // set custom title and keep the default separator and site name
    add_filter('document_title_parts', function ($title) {
        $title['title'] = __('Renderer', 'flynt');
        return $title;
    }, 99);
}
