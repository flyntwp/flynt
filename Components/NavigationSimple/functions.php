<?php

namespace Flynt\NavigationSimple;

use Timber;
use Flynt\Utils\Asset;

add_action('init', function () {
    register_nav_menus([
        'navigation_simple' => __('Navigation Simple', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationSimple', function ($data) {
    $data['menu'] = new Timber\Menu('navigation_simple');
    $data['logo'] = [
        'src' => Asset::requireUrl(
            'Components/NavigationSimple/Assets/logo.svg'
        ),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});
