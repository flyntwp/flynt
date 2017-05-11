<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Features\Components\Component;
use Timber\Menu;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationMain');
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;
    return $data;
});
