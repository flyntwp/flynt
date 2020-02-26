<?php

namespace Flynt\TimberDynamicResize;

use Flynt\Utils\TimberDynamicResize;

/**
 * Disable dynamic image generation and fall back
 * to regular timber resize functionality.
 */
// add_filter('Flynt/TimberDynamicResize/disableDynamic', '__return_true');

/**
 * Disable WebP generation
 */
// add_filter('Flynt/TimberDynamicResize/disableWebp', '__return_true');

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

new TimberDynamicResize();
