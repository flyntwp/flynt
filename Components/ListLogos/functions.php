<?php

namespace Flynt\Components\ListLogos;

use Flynt\Api;

add_filter('Flynt/addComponentData?name=ListLogos', function ($data) {

    if (!empty($data['items'])) {
        $data['items'] = array_map(function ($item) {
            if (isset($item['image']->post_mime_type) && $item['image']->post_mime_type === 'image/svg+xml') {
                $path = get_attached_file($item['image']->ID);
                $item['image']->svg = file_get_contents($path);
            }
            return $item;
        }, $data['items']);
    }
    return $data;
});

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
                'label' => 'Title',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
            ],
            [
                'label' => 'Logos',
                'name' => 'logosAccordion',
                'type' => 'accordion',
                'open' => 0,
                'multi_expand' => 0,
                'endpoint' => 0,
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
                            'width' => '60',
                        ]
                    ],
                    [
                        'label' => 'Source',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'array',
                        'preview_size' => 'small',
                        'library' => 'all',
                        'min_width' => 384,
                        'min_height' => 216,
                        'max_size' => 2.5,
                        'mime_types' => 'png',
                        'required' => 1,
                        'wrapper' =>  [
                            'width' => '40',
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
                    Api::loadFields('FieldVariables', 'theme'),
                    [
                        'label' => 'Show as Card',
                        'name' => 'card',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                ]
            ],
        ]
    ]
]);
