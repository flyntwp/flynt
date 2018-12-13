<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Component;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt-starter-theme')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    Component::enqueueAssets('NavigationFooter');

    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : 'navigation_footer';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;

    return $data;
});
