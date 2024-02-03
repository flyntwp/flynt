<?php

namespace Flynt\Utils;

use DOMDocument;

/**
 * Provides a set of methods that are used to modify oembeds.
 */
class Oembed
{
    /**
     * Sets an oembed source as data attribute.
     * Possibility to append query variables to the URL by using additional get parameters.
     *
     * @since 0.2.0
     *
     * @param string $iframeTagHtml The oembed iframe HTML tag.
     * @param array $additionalGetParams Associative array of key/values of additional query variables to append to the url.
     *
     * @return string The modified oembed iframe HTML tag.
     */
    public static function setSrcAsDataAttribute(string $iframeTagHtml, array $additionalGetParams): string
    {
        $output = '';
        if ($iframeTagHtml !== '' && $iframeTagHtml !== '0') {
            $domDocument = new DOMDocument();
            $domDocument->loadHTML($iframeTagHtml);
            $domNodes = $domDocument->getElementsByTagName('iframe');
            foreach ($domNodes as $domNode) {
                $src = $domNode->getAttribute('src');
                // Add additional get parameters to existing oembed url.
                $src = add_query_arg($additionalGetParams, $src);
                $domNode->removeAttribute('src');
                $domNode->setAttribute('data-src', $src);
                $output .= $domDocument->saveHTML($domNode);
            }
        }

        return $output;
    }
}
