<?php

namespace Flynt\Components\BlockWysiwygSidebar;

use Flynt\Api;

Api::registerFields('BlockWysiwygSidebar', [
    'layout' => [
        'name' => 'blockWysiwygSidebar',
        'label' => 'Block: Wysiwyg Sidebar',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Sidebar',
                'name' => 'sidebarHtml',
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'toolbar' => 'full',
                'required' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Content',
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'toolbar' => 'full',
                'required' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Options',
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => 'Theme',
                        'name' => 'theme',
                        'type' => 'select',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'ajax' => 0,
                        'choices' => [
                            '' => 'Default',
                            'themeLight' => 'Light',
                            'themeDark' => 'Dark',
                            'themeHero' => 'Hero'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
