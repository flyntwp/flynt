<?php

namespace Flynt\Theme\Helpers;

class DomNode {
  public static function setSrcDataAttribute($nodeHtml, $elementTagName, $attributeName, $toAddGetParams) {
    $output = '';
    $DOM = new \DOMDocument();
    $DOM->loadHTML($nodeHtml);
    $domNodes = $DOM->getElementsByTagName($elementTagName);

    foreach ($domNodes as $node) {
      $attribute = $node->getAttribute($attributeName);
      $attribute = add_query_arg($toAddGetParams, $attribute);
      $node->removeAttribute($attributeName);
      $node->setAttribute("data-{$attributeName}", $attribute);
      $output .= $DOM->saveHTML($node);
    }
    return $output;
  }
}
