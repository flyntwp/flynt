<?php

/**
 * Side load external avatar images in relation to GDPR.
 *
 * @param string $url
 * @return string
 */

 namespace Flynt\GetAvatarUrl;

use Timber\ImageHelper;
use Timber\URLHelper;

add_filter('get_avatar_url', function (string $url): string {
    if (URLHelper::is_external_content($url)) {
        $url = ImageHelper::sideload_image($url);
    }
    return $url;
}, 10, 1);
