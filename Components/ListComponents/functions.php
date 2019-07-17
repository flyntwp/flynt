<?php

namespace Flynt\Components\ListComponents;

use Flynt\Api;
use Flynt\ComponentManager;
use Flynt\Utils\Asset;

add_filter('Flynt/addComponentData?name=ListComponents', function ($data) {
    if (!empty($data['componentBlocks'])) {
        $data['componentBlocks'] = array_map(function ($block) {
            $componentPaths = explode('/', $block['component']);
            $block['component'] = implode('/', array_slice($componentPaths, count($componentPaths)-3, 3));

            if (file_exists(Asset::requirePath($block['component'] . 'screenshot.png'))) {
                $src = Asset::requireUrl($block['component'] . 'screenshot.png');
                list($width, $height) = getimagesize(Asset::requirePath($block['component'] . 'screenshot.png'));

                $block['componentScreenshot'] = [
                    'src' => $src,
                    'aspect' => $width / $height
                ];
            }

            $readme = Asset::requirePath($block['component'] . 'README.md');

            if (file_exists($readme)) {
                $block['readme'] = parseComponentReadme(file_get_contents($readme));
            }

            return $block;
        }, $data['componentBlocks']);
    }

    return $data;
});

add_filter('acf/load_field/name=component', function ($field) {
    $componentManager = ComponentManager::getInstance();
    $field['choices'] = array_flip($componentManager->getAll());
    return $field;
});

function parseComponentReadme($file) {
    $content = [];
    $fields = preg_split('!\n---\s*\n*!', $file);
    foreach ($fields as $field) {
        $pos = strpos($field, ':');
        $key = str_replace(['-', ' '], '_', strtolower(trim(substr($field, 0, $pos))));
        if (empty($key)) {
            continue;
        }
        $content[$key] = trim(substr($field, $pos + 1));
        if ($key === 'text') {
            $content['html'] = $content[$key];
        }
    }
    return $content;
}

Api::registerFields('ListComponents', [
    'layout' => [
        'name' => 'listComponents',
        'label' => 'List: Components',
        'sub_fields' => [
            [
                'label' => 'Component Blocks',
                'name' => 'componentBlocks',
                'type' => 'repeater',
                'collapsed' => 0,
                'min' => 1,
                'layout' => 'block',
                'button_label' => 'Add Component Block',
                'sub_fields' => [
                    [
                        'label' => 'Component',
                        'name' => 'component',
                        'type' => 'select',
                        'ui' => 1,
                        'ajax' => 0,
                        'choices' => []
                    ],
                    [
                        'label' => 'Calls To Action',
                        'name' => 'ctas',
                        'type' => 'repeater',
                        'collapsed' => 0,
                        'layout' => 'table',
                        'button_label' => 'Add Call To Action',
                        'sub_fields' => [
                            [
                                'label' => 'Link',
                                'name' => 'link',
                                'type' => 'link',
                                'return_format' => 'array',
                                'required' => 1,
                                'wrapper' => [
                                    'width' => 70
                                ]
                            ],
                            [
                                'label' => 'Button Type',
                                'name' => 'buttonType',
                                'type' => 'button_group',
                                'choices' => [
                                    'primary' => 'Primary',
                                    'secondary' => 'Secondary'
                                ],
                                'wrapper' => [
                                    'width' => 30
                                ],
                                'ui' => 1
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
