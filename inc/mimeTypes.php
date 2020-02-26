<?php

/**
 * Adds SVG to the mime types supported (useful for gallery uploads in the WP Backend).
 */

namespace Flynt\MimeTypes;

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});
