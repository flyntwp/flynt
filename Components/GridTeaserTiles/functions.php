<?php

namespace Flynt\Components\GridTeaserTiles;

use Flynt;

add_filter('Flynt/addComponentData?name=GridTeaserTiles', function ($data) {
    return $data;
});

Flynt\registerFields('GridTeaserTiles', [
    'layout' => [
        'name' => 'GridTeaserTiles',
        'label' => 'Grid: TeaserTiles',
        'sub_fields' => [
            [
                'label' => 'Teaser Tiles',
                'name' => 'teaserItems',
                'type' => 'repeater',
                'layout' => 'block',
                'min' => 1,
                'button_label' => 'Add Teaser Item',
                'sub_fields' => [
                    [
                        'label' => 'Only Text',
                        'name' => 'itemType',
                        'type' => 'true_false',
                        'ui' => true,
                        'ajax' => false,
                    ],
                    [
                        'label' => 'Content',
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'toolbar' => 'full',
                        'media_upload' => false,
                        'delay' => true,
                        'wrapper' => [
                            'class' => 'autosize',
                        ],
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '!=',
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'instructions' => '',
                        'max_size' => 4,
                        'mime_types' => 'gif,jpg,jpeg,png',
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Width',
                        'name' => 'itemWidth',
                        'type' => 'select',
                        'allow_null' => false,
                        'multiple' => false,
                        'ui' => true,
                        'ajax' => false,
                        'choices' => [
                            'default' => 'Default',
                            'half' => 'Half',
                            'full' => 'Full'
                        ],
                        'default_value' => 'default'
                    ],
                ],
            ],
        ],
    ],
]);
