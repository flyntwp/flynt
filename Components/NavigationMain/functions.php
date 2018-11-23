<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Features\Components\Component;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt-starter-theme')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('NavigationFooter');
    });

    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;

    return $data;
});
