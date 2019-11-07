<?php

namespace Flynt\Components\BlockCountUp;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('BlockCountUp', [
    'layout' => [
        'name' => 'BlockCountUp',
        'label' => 'Block: Count Up',
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
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1
            ],
            [
                'label' => 'Items',
                'name' => 'items',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'row',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    Api::loadFields('FieldVariables', 'icon'),
                    [
                        'label' => 'Count Value',
                        'name' => 'numberGroup',
                        'type' => 'group',
                        'layout' => 'table',
                        'sub_fields' => [
                            [
                                'label' => 'Prefix',
                                'name' => 'numberPrefix',
                                'type' => 'text'
                            ],
                            [
                                'label' => 'Number',
                                'name' => 'number',
                                'type' => 'number',
                                'required' => 1
                            ],
                            [
                                'label' => 'Suffix',
                                'name' => 'numberSuffix',
                                'type' => 'text'
                            ]
                        ]
                    ],
                    [
                        'label' => 'Subtitle',
                        'name' => 'subtitle',
                        'type' => 'text'
                    ],
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
                    Api::loadFields('FieldVariables', 'theme')
                ]
            ]
        ]
    ]
]);

Options::addTranslatable('BlockCountUp', [
    [
        'label' => 'Decimal Separator',
        'name' => 'decimalSeparator',
        'type' => 'text',
        'required' => 1,
        'default_value' => ','
      ],
      [
        'label' => 'Thousands Separator',
        'name' => 'thousandsSeparator',
        'type' => 'text',
        'required' => 1,
        'default_value' => '.'
      ]
]);
