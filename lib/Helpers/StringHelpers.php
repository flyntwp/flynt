<?php

namespace WPStarterTheme\Helpers\StringHelpers;

function camelCaseToKebap($className) {
  return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
}
