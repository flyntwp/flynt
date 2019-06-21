<?php

namespace Flynt\Components\BlockWysiwygTwoCol;

use Flynt\Api;

Api::registerFields('BlockWysiwygTwoCol', [
    'layout' => [
        'name' => 'blockWysiwygTwoCol',
        'label' => 'Block: Wysiwyg Two Col',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Title',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'media_upload' => 0,
                'toolbar' => 'full',
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'name' => 'contentHtml',
                'label' => 'Content',
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
