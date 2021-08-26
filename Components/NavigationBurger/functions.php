<?php

namespace Flynt\Components\NavigationBurger;

use Flynt\Utils\Asset;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_burger' => __('Navigation Burger', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationBurger', function ($data) {
    $data['menu'] = new Menu('navigation_burger');
    $data['logo'] = [
        'src' => get_theme_mod('custom_header_logo') ? get_theme_mod('custom_header_logo') : Asset::requireUrl('Components/NavigationBurger/Assets/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});
