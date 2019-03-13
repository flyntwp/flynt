<?php

namespace Flynt\Components\GridTeaserTiles;

use Flynt\Api;

Api::registerFields('GridTeaserTiles', [
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
                        'label' => 'Choose Format',
                        'name' => 'itemType',
                        'type' => 'select',
                        'allow_null' => false,
                        'multiple' => false,
                        'ui' => true,
                        'ajax' => false,
                        'choices' => [
                            'wysiwyg' => 'WYSIWYG',
                            'box' => 'BOX',
                            'cta' => 'CTA',
                        ],
                        'default_value' => 'wysiwyg'
                    ],
                    [
                        'label' => 'Content',
                        'name' => 'contentHtml',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'delay' => 1,
                        'required' => '1',
                        'wrapper' => [
                            'class' => 'autosize',
                        ],
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'wysiwyg',
                                ]
                            ]
                        ]
                    ],
                    [
                        "label" => "Image",
                        "name" => "image",
                        "type" => "image",
                        "return_format" => "array",
                        "preview_size" => "thumbnail",
                        "library" => "all",
                        "mime_types" => "jpg,jpeg,png",
                        'required' => '1',
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'box',
                                ]
                            ]
                        ]
                    ],
                    [
                        "label" => "Link",
                        "type" => "link",
                        "name" => "link",
                        "return_format" => "array",
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'box',
                                ]
                            ],
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'cta',
                                ]
                            ]
                        ]
                    ],
                ],
            ],
        ],
    ],
]);
