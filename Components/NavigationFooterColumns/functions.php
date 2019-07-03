<?php

namespace Flynt\Components\NavigationFooterColumns;

use Timber\Menu;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer_columns' => __('Navigation Footer Columns', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooterColumns', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = new Menu('navigation_footer_columns');
    $data['logo'] = [
        'src' => Asset::requireUrl('Components/NavigationFooterColumns/Assets/logo.svg'),
        'alt' => get_bloginfo('name')
    ];

    return $data;
});

Options::addTranslatable('NavigationFooterColumns', [
    [
    'label' => 'Social media label',
    'name' => 'socialMediaLabel',
    'type' => 'text',
    'default_value' => 'Follow us on social media'
    ],
    [
    'label' => 'Social links',
    'name' => 'links',
    'type' => 'repeater',
    'min' => 0,
    'max' => 6,
    'layout' => 'row',
    'button_label' => 'Add Item',
    'sub_fields' => [
        [
            'label' => 'Icon',
            'name' => 'icon',
            'type' => 'select',
            'allow_null' => 1,
            'multiple' => 0,
            'ui' => 1,
            'ajax' => 0,
            'choices' => [
                'codepen' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="codepen"></i> codepen',
                'facebook' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="facebook"></i> facebook',
                'github' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="github"></i> github',
                'instagram' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="instagram"></i> instagram',
                'linkedin' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="linkedin"></i> linkedin',
                'mail' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="mail"></i> mail',
                'slack' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="slack"></i> slack',
                'trello' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="trello"></i> trello',
                'twitter' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="twitter"></i> twitter',
                'youtube' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="youtube"></i> youtube'
            ]
        ],
        [
        'label' => 'Url',
        'name' => 'url',
        'placeholder' => 'https://',
        'type' => 'text',
        'return_format' => 'array'
        ],
    ]
    ],
    [
        'label' => 'Copyright text',
        'name' => 'copyright',
        'type' => 'text',
        'default_value' => 'Copyright &copy; 2019 All rights reserved'
    ]
]);
