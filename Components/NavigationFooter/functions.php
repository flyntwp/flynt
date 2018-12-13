<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Features\Components\Component;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt-starter-theme')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('NavigationFooter');
    });

    $data['maxLevel'] = 0;
    $data['menu'] = new Menu('navigation_footer');

    return $data;
});
