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

  public static function strstartswith($haystack, $needle) {
    if (!$needle) return false;
    return strpos($haystack, $needle) === 0;
  }
}
