<?php

/**
 * Download and serve external avatar images from local server.
 */

namespace Flynt\SideloadAvatarImages;

use Timber\ImageHelper;
use Timber\URLHelper;

add_filter('get_avatar_url', function (string $url): string {
    if (URLHelper::is_external_content($url)) {
        return ImageHelper::sideload_image($url);
    }

    return $url;
}, 10, 1);
