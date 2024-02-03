<?php

/**
 * Moves the Yoast SEO plugin box to the bottom of the backend interface.
 */

namespace Flynt\YoastToBottom;

add_filter('wpseo_metabox_prio', function (): string {
    return 'low';
});
