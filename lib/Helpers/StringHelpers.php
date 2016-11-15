<?php

namespace WPStarterTheme\Helpers;

class StringHelpers {
  public static function camelCaseToKebap($className) {
    return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
  }
}
