<?php

namespace Flynt\Components\MainNavigation;

use Timber\Menu;

add_filter('Flynt/modifyComponentData?name=MainNavigation', function ($data) {
  $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
  $data['menu'] = new Menu($data['menuSlug']);
  return $data;
});
