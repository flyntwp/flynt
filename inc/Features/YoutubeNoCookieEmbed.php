<?php

namespace Flynt\Features\YoutubeNoCookieEmbed;

use Flynt\Utils\Oembed;

add_action('oembed_result', 'Flynt\Features\YoutubeNoCookieEmbed\setNoCookieDomain', 10, 2);
add_filter('embed_oembed_html', 'Flynt\Features\YoutubeNoCookieEmbed\setNoCookieDomain', 10, 2);

function setNoCookieDomain($searchString, $url)
{
    if (preg_match('#https?://(www\.)?youtube\.com#i', $searchString)) {
        $searchString = preg_replace(
            '#(https?:)?//(www\.)?youtube\.com#i',
            '$1//$2youtube-nocookie.com',
            $searchString
        );
    }

    return $searchString;
}
