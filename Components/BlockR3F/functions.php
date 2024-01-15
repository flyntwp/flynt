<?php

namespace Flynt\Components\BlockR3F;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BlockR3F', function ($data) {
    $data['jsonData'] = [
        'gltfModelUrl' =>  $data['gltfModel']['url'],
        'tooltips' => $data['tooltips'],
        'backgroundColor' => $data['backgroundColor'],
        'enableOrbitControl' => $data['options']['enableOrbitControl'],
        'enableAutoRotation' => $data['options']['enableAutoRotation'],
        'modelPosition' => $data['options']['modelPosition'],
        'modelScale' => $data['options']['modelScale'],
    ];
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockR3F',
        'label' => __('Block: R3F', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Text', 'flynt'),
                'name' => 'contentHtml',
                'type' => 'wysiwyg',
                'delay' => 0,
                'media_upload' => 0,
            ],
            [
                'label' => __('Background Color', 'flynt'),
                'name' => 'backgroundColor',
                'type' => 'color_picker',
                'default_value' => '#ffd291',
            ],
            [
                'label' => __('GLTF Model', 'flynt'),
                'name' => 'gltfModel',
                'type' => 'file',
                'return_format' => 'array',
                'library' => 'all',
                'mime_types' => 'gltf,glb'
            ],
            [
                'label' => __('Tooltips', 'flynt'),
                'name' => 'tooltips',
                'type' => 'repeater',
                'max' => 12,
                'hide_collapse' => 1,
                'layout' => 'row',
                'button_label' => __('Add Tooltip', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text'
                    ],
                    [
                        'label' => __('Position', 'flynt'),
                        'name' => 'position',
                        'type' => 'group',
                        'layout' => 'block',
                        'sub_fields' => [
                            [
                                'label' => __('Y', 'flynt'),
                                'name' => 'y',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                            ],
                            [
                                'label' => __('Z', 'flynt'),
                                'name' => 'z',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                                'wrapper' => [
                                    'width' => 50
                                ]
                            ],
                            [
                                'label' => __('X', 'flynt'),
                                'name' => 'x',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                                'wrapper' => [
                                    'width' => 50
                                ]
                            ],
                        ]
                    ],
                ]
            ],
            [
                'label' => __('Options', 'flynt'),
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
                        'label' => __('Enable Orbit Control', 'flynt'),
                        'name' => 'enableOrbitControl',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1
                    ],
                    [
                        'label' => __('Enable Auto Rotation', 'flynt'),
                        'name' => 'enableAutoRotation',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1
                    ],
                    [
                        'label' => __('Model', 'flynt'),
                        'name' => 'modelAcc',
                        'type' => 'accordion',
                        'open' => 0,
                        'multi_expand' => 1,
                        'endpoint' => 0
                    ],
                    [
                        'label' => __('Model Position', 'flynt'),
                        'name' => 'modelPosition',
                        'type' => 'group',
                        'layout' => 'block',
                        'sub_fields' => [
                            [
                                'label' => __('Y', 'flynt'),
                                'name' => 'y',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                            ],
                            [
                                'label' => __('Z', 'flynt'),
                                'name' => 'z',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                                'wrapper' => [
                                    'width' => 50
                                ]
                            ],
                            [
                                'label' => __('X', 'flynt'),
                                'name' => 'x',
                                'type' => 'range',
                                'step' => 0.05,
                                'min' => -10,
                                'max' => 10,
                                'default_value' => 0,
                                'wrapper' => [
                                    'width' => 50
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => __('Model Scale', 'flynt'),
                        'name' => 'modelScale',
                        'type' => 'number',
                        'step' => 0.01,
                        'default_value' => 1
                    ],
                ]
            ]
        ]
    ];
}
