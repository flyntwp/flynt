<?php

namespace Flynt\Components\GridDownloadPortrait;

use Flynt\Api;

add_filter('Flynt/addComponentData?name=GridDownloadPortrait', function ($data) {
    if (!empty($data['items'])) {
        $data['items'] = array_map(function ($item) {
            if ($item['itemType'] === 'itemFile') {
                $fileSize = filesize(get_attached_file($item['file']['id']));
                $item['file']['fileSize'] = size_format($fileSize);
            }
            return $item;
        }, $data['items']);
    }

    return $data;
});

Api::registerFields('GridDownloadPortrait', [
    'layout' => [
        'name' => 'gridDownloadPortrait',
        'label' => 'Grid: Download Portrait',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Pre-Content',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'instructions' => 'Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ],
            [
                'label' => 'Items',
                'name' => 'items',
                'type' => 'repeater',
                'layout' => 'horizontal',
                'required' => 1,
                'button_label' => 'Add item',
                'sub_fields' => [
                    [
                        'label' => 'Item Type',
                        'name' => 'itemType',
                        'type' => 'select',
                        'allow_null' => false,
                        'multiple' => false,
                        'ui' => true,
                        'ajax' => false,
                        'choices' => [
                            'itemFile' => 'File',
                            'itemLink' => 'Link'
                        ],
                        'default_value' => 'itemFile'
                    ],
                    [
                        'label' => 'File',
                        'name' => 'file',
                        'type' => 'file',
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'itemFile'
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'link',
                        'return_format' => 'array',
                        'required' => 1,
                        'conditional_logic' => [
                            [
                                [
                                    'fieldPath' => 'itemType',
                                    'operator' => '==',
                                    'value' => 'itemLink'
                                ]
                            ]
                        ]
                    ],
                    [
                        'label' => 'Preview Image',
                        'name' => 'image',
                        'type' => 'image',
                        'mime_types' => 'jpg,jpeg',
                        'min_height' => 508,
                        'min_width' => 360,
                        'preview_size' => 'thumbnail'
                    ]
                ]
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
