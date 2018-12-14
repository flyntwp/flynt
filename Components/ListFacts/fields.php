<?php

Flynt\registerFields('ListFacts', [
    'layout' => [
        'name' => 'listFacts',
        'label' => 'List: Facts',
        'sub_fields' => [
            [
                'label' => 'Pre-Content',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'instructions' => 'Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize'
                ]
            ],
            [
                'label' => 'Column',
                'type' => 'repeater',
                'name' => 'columns',
                'collapsed' => '',
                'min' => 1,
                'max' => 3,
                'layout' => 'row',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    [
                        'label' => 'Number',
                        'name' => 'columnNumber',
                        'type' => 'number',
                        'required' => 1
                    ],
                    [
                        'label' => '\'Count to\' Number',
                        'name' => 'countToNumber',
                        'type' => 'number',
                        'instructions' => 'Optional; used only for calculating counting speed. For example, if the numer is 1,000 B, enter 1000000000.'
                    ],
                    [
                        'label' => 'Suffix',
                        'name' => 'columnSuffix',
                        'type' => 'text'
                    ],
                    [
                        'label' => 'Content',
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'delay' => 1,
                        'wrapper' => [
                            'class' => 'autosize'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
