<?php

namespace WPStarterTheme\Helpers;

class StringHelpers {
  public static function camelCaseToKebap($className) {
    return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
  }

  public static function trimStrip($str, $length = 25) {
    if(isset($str))
      return wp_trim_words(wp_strip_all_tags($str), $length, '...');
  }

  public static function splitCamelCase($input) {
    $a = preg_split(
      '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
      $input,
      -1, /* no limit for replacement count */
      PREG_SPLIT_NO_EMPTY /*don't return empty elements*/
      | PREG_SPLIT_DELIM_CAPTURE /*don't strip anything from output array*/
    );
    return join($a, ' ');
  }

  public static function strstartswith($haystack, $needle) {
    if (!$needle) return false;
    return strpos($haystack, $needle) === 0;
  }
}
