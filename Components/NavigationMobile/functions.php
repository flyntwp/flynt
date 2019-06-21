<?php

namespace Flynt\NavigationMobile;

use Timber;
use Flynt\Utils\Asset;

add_action('init', function () {
    register_nav_menus([
        'navigation_mobile' => __('Navigation Mobile', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMobile', function ($data) {
    $data['menu'] = new Timber\Menu('navigation_mobile');
    $data['logo'] = [
        'src' => Asset::requireUrl(
            'Components/NavigationMobile/Assets/logo.svg'
        ),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});
