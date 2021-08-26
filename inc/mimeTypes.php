<?php

/**
 * Adds SVG to the mime types supported (useful for gallery uploads in the WP Backend).
 */

namespace Flynt\MimeTypes;

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

// If you use a SVG Optimizer like svgo the xml will be removed by default.
// The fix will add the type "image/svg+xml" to files without a xml tag.
// Details: https://wordpress.stackexchange.com/questions/340523/why-does-svg-upload-in-media-library-fail-if-the-file-does-not-have-an-xml-tag-a
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes, $real_mime) {

    if (!empty($data['ext']) && !empty($data['type'])) {
        return $data;
    }

    $wp_file_type = wp_check_filetype($filename, $mimes);

    if ($wp_file_type['ext'] === 'svg' && $real_mime === "image/svg") {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}, 10, 5);
