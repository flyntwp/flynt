<?php

namespace Flynt\Components\NavigationMain;

use Timber;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    $data['menu'] = new Timber\Menu('navigation_main');
    $data['logo'] = [
        'src' => Asset::requireUrl('Components/NavigationMain/Assets/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});

Options::addTranslatable('NavigationMain', [
    [
        'label' => 'Accessibility',
        'name' => 'a11y',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Aria Label for Menu',
                'name' => 'labelMenu',
                'type' => 'text',
                'default_value' => 'Main',
                'required' => 1,
            ]
        ],
    ],
]);
