<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Utils\Component;
use Timber\Menu;
use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationMain');
});

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt-starter-theme')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = new Menu('navigation_main');

    $data['siteTitle'] = get_bloginfo('name');
    $data['logo'] = Asset::requireUrl('Components/NavigationMain/Assets/logo.svg');

    return $data;
});
