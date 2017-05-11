<?php

namespace Flynt\Utils;

use DOMDocument;

class Oembed
{
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
