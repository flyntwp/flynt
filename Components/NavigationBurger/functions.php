<?php

namespace Flynt\Components\NavigationBurger;

use Timber;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;

add_action('init', function () {
    register_nav_menus([
        'navigation_burger' => __('Navigation Burger', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationBurger', function ($data) {
    $data['menu'] = new Timber\Menu('navigation_burger');
    $data['logo'] = [
        'src' => Asset::requireUrl(
            'Components/NavigationBurger/Assets/logo.svg'
        ),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});

Options::addTranslatable('NavigationBurger', [
    [
        'label' => 'Accessibility',
        'instructions' => 'Text labels for screen readers.',
        'name' => 'a11y',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Aria Label for Menu',
                'name' => 'labelMenu',
                'type' => 'text',
                'default_value' => 'Main',
                'required' => 1,
            ],
            [
                'label' => 'Toggle Menu Button',
                'name' => 'toggleMenuButton',
                'type' => 'text',
                'required' => 1,
                'default_value' => 'Toggle Menu'
            ]
        ]
    ]
]);
