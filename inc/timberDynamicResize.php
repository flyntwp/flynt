<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\TimberDynamicResize;
use Twig\TwigFilter;

/**
 * Disable dynamic images and fall back to regular
 * Timber resize filter
 */
// add_filter('Flynt/TimberDynamicResize/disable', __return_true);

/**
 * Disable WebP generation
 */
// add_filter('Flynt/TimberDynamicResize/disableWebP', __return_true);

/**
 * Disable adding of rewrite rules to htaccess
 */
// add_filter('Flynt/TimberDynamicResize/disableHtaccess', __return_true);

/**
 * Set upload directory relative to web root.
 * If there are issues with image generation,
 * this filter most likely needs to be used.
 * Can be related to having a custom WordPress folder
 * structure or plugins that manipulate home_url.
 */
// add_filter('Flynt/TimberDynamicResize/relativeUploadDir', function () {
//     return '/app/uploads';
// });

call_user_func(function () {
    if (apply_filters('Flynt/TimberDynamicResize/disable', false)) {
        add_action('timber/twig/filters', function ($twig) {
            $twig->addFilter(
                new TwigFilter('resizeDynamic', ['Timber\ImageHelper', 'resize'])
            );
            return $twig;
        });
    } else {
        new TimberDynamicResize();
    }
});
