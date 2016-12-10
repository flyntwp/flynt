<?php

namespace WPStarterTheme\DataFilters;

use Timber\Timber;
use Timber\Menu;

add_filter(
  'WPStarterTheme/DataFilters/Navigation',
  ['WPStarterTheme\DataFilters\Navigation', 'getMenu'],
  10,
  2
);

class Navigation {

  public static function getMenu($data, $menuSlug = '') {
    $data['menu'] = new Menu($menuSlug);
    return $data;
  }

}
