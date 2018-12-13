<?php

Flynt\registerFields('GridListSteps', [
    'layout' => [
        'name' => 'gridListSteps',
        'label' => 'Grid: ListSteps',
        'sub_fields' => [
            [
                'label' => 'Pre Content Html',
                'name' => 'preContentHtml',
                'instructions' => 'Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Step List',
                'type' => 'repeater',
                'name' => 'stepList',
                'collapsed' => '',
                'min' => 0,
                'max' => 0,
                'layout' => 'table',
                'button_label' => 'Add Steps',
                'sub_fields' => [
                    [
                        'label' => 'Content',
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'delay' => 1,
                        'wrapper' => [
                            'class' => 'autosize',
                        ],
                    ]
                ]
            ]
        ]
    ]
]);
