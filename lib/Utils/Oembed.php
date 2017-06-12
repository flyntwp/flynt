<?php

namespace Flynt\Utils;

use DOMDocument;

class Oembed
{
    /**
     * Sets an oembed source as data attribute.
     * Possibility to append query variables to the URL by using additional get parameters.
     *
     * @since %%NEXT_VERSION%%
     *
     * @param $iframeTagHtml string The oembed iframe HTML tag.
     * @param $additionalGetParams array Associative array of key/values of additional query variables to append to the url.
     *
     * @return string The modified oembed iframe HTML tag.
     */
    public static function setSrcAsDataAttribute($iframeTagHtml, $additionalGetParams)
    {
        $output = '';
        $Dom = new DOMDocument();
        $Dom->loadHTML($iframeTagHtml);
        $domNodes = $Dom->getElementsByTagName('iframe');
        foreach ($domNodes as $node) {
            $src = $node->getAttribute('src');
            // add additional get parameters to existing oembed url
            $src = add_query_arg($additionalGetParams, $src);
            $node->removeAttribute('src');
            $node->setAttribute('data-src', $src);
            $output .= $Dom->saveHTML($node);
        }
        return $output;
    }
}
