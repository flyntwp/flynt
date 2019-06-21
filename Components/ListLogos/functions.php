<?php

namespace Flynt\Components\ListLogos;

use Flynt\Api;

Api::registerFields('ListLogos', [
    'layout' => [
        'name' => 'listLogos',
        'label' => 'List: Logos',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'general',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'placeholder' => 'optional',
                    ],
                    [
                        'label' => 'Intro',
                        'name' => 'intro',
                        'type' => 'textarea',
                        'maxlength' => 240,
                        'rows' => 3,
                        'new_lines' => '',
                        'placeholder' => 'optional',
                    ],
                ]
            ],
            [
                'label' => 'Logos',
                'name' => 'logosAccordion',
                'type' => 'accordion',
                'open' => 0,
                'multi_expand' => 0,
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'items',
                'type' => 'repeater',
                'collapsed' => '',
                'min' => 1,
                'max' => 8,
                'layout' => 'block',
                'instructions' => '<b>Source:</b> 384 x 216px Minimum - <b>Ratio:</b> 16:9 - <b>Format:</b> PNG',
                'button_label' => 'Add',
                'sub_fields' => [
                    [
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'wrapper' =>  [
                            'width' => '60'
                        ]
                    ],
                    [
                        'label' => 'Source',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => 384,
                        'min_height' => 216,
                        'max_size' => 2.5,
                        'mime_types' => 'png',
                        'required' => 1,
                        'wrapper' =>  [
                            'width' => '40'
                        ]
                    ]
                ]
            ],
            [
                'label' => '',
                'name' => 'logosAccordionEnd',
                'type' => 'accordion',
                'open' => 0,
                'multi_expand' => 0,
                'endpoint' => 1,
            ],
            [
                'label' => 'Options',
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'sub_fields' => [
                    [
                        'label' => 'Theme',
                        'name' => 'theme',
                        'type' => 'group',
                        'layout' => 'row',
                        'sub_fields' => [
                            [
                                'label' => 'Background',
                                'name' => 'backgroundColor',
                                'type' => 'select',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'ajax' => 0,
                                'choices' => [
                                    '' => 'Default',
                                    'themeLight' => 'Light',
                                    'themeDark' => 'Dark',
                                    'themeHero' => 'Hero',
                                ]
                            ],
                            [
                                'label' => 'Card',
                                'name' => 'card',
                                'type' => 'true_false',
                                'default_value' => 0,
                                'ui' => 1
                            ],
                        ]
                    ],
                ]
            ],
        ]
    ]
]);
