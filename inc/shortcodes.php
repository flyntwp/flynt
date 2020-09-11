<?php

/**
 * Flynt Shortcodes
 */

namespace Flynt\Shortcodes;

/**
 * Current year
 */
add_shortcode('year', function () {
    $year = date_i18n('Y');
    return $year;
});

/**
 * Site Title
 */
add_shortcode('sitetitle', function () {
    $blogname = get_bloginfo(false, 'name');
    return $blogname;
});

/**
 * Tagline
 */
add_shortcode('tagline', function () {
    $tagline = get_bloginfo(false, 'description');
    return $tagline;
});
