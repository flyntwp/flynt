<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Utils\Asset;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    $data['menu'] = new Menu('navigation_main');
    $data['logo'] = [
        'src' => get_theme_mod('custom_header_logo') ? get_theme_mod('custom_header_logo') : Asset::requireUrl('Components/NavigationMain/Assets/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});
