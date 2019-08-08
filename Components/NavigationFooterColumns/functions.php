<?php

namespace Flynt\Components\NavigationFooterColumns;

use Timber\Menu;
use Timber\Site;
use Flynt\Utils\Asset;
use Flynt\Utils\Options;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer_columns' => __('Navigation Footer Columns', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooterColumns', function ($data) {
    $area = 'navigation_footer_columns';
    $id = 1;
    $menu = new Menu($area);
    $site = new Site($id);

    $data['menu'] = $menu;
    $data['site'] = [
        'logo' => Asset::getContents('Components/NavigationFooterColumns/Assets/ico-site-logo.svg'),
        'info' => $site
    ];

    return $data;
});

Options::addTranslatable('NavigationFooterColumns', [
    [
        'label' => '',
        'name' => 'generalTranslatable',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Channel - Info',
                'name' => 'channelInfo',
                'type' => 'text',
                'default_value' => 'Follow us',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
            [
                'label' => 'Channel - Links',
                'name' => 'channelLinks',
                'type' => 'repeater',
                'min' => 0,
                'max' => 0,
                'layout' => 'block',
                'button_label' => 'Add',
                'sub_fields' => [
                    [
                        'label' => '',
                        'name' => 'channel',
                        'type' => 'select',
                        'allow_null' => 1,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'choices' => [
                            'codepen' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="codepen"></i> Codepen',
                            'facebook' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="facebook"></i> Facebook',
                            'github' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="github"></i> Github',
                            'instagram' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="instagram"></i> Instagram',
                            'linkedin' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="linkedin"></i> LinkedIn',
                            'mail' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="mail"></i> Mail',
                            'slack' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="slack"></i> Slack',
                            'trello' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="trello"></i> Trello',
                            'twitter' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="twitter"></i> Twitter',
                            'youtube' => '<i style="width: 16px; height: 16px; vertical-align: middle; position: relative; top: -2px;margin-right: 5px" data-feather="youtube"></i> YouTube'
                        ],
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                    [
                        'label' => '',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'placeholder' => 'https://',
                        'wrapper' => [
                            'width' => 50,
                        ],
                    ],
                ]
            ],
            [
                'label' => 'Legal - Links',
                'name' => 'legalLinks',
                'type' => 'repeater',
                'min' => 0,
                'max' => 3,
                'layout' => 'block',
                'button_label' => 'Add',
                'sub_fields' => [
                    [
                        'label' => '',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'placeholder' => 'https://',
                    ],
                ]
            ],
            [
                'label' => 'Copyright - Info',
                'name' => 'copyrightInfo',
                'type' => 'text',
                'default_value' => 'Copyright &copy; 2019 All rights reserved',
                'wrapper' => [
                    'width' => 100,
                ],
            ],
        ],
    ],
]);

Options::addGlobal('NavigationFooterColumns', [
    [
        'label' => '',
        'name' => 'generalOptions',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Menu - Layout',
                'name' => 'menuColumns',
                'type' => 'range',
                'min' => 2,
                'max' => 4,
                'step' => 1,
                'prepend' => '1',
                'append' => 'Columns',
                'default_value' => 4,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Menu - Depth',
                'name' => 'menuDepth',
                'type' => 'range',
                'min' => 1,
                'max' => 1,
                'step' => 1,
                'prepend' => '1',
                'append' => 'Level',
                'default_value' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
