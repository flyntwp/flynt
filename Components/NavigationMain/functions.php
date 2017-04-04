<?php

namespace Flynt\Components\NavigationMain;

use Timber\Menu;

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
    $data['menu'] = new Menu($data['menuSlug']);
    return $data;
});
