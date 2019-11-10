<?php

namespace Flynt\Components\ListComponents;

use Flynt\Api;
use Flynt\ComponentManager;
use Flynt\Utils\Options;
use Flynt\Utils\Asset;
use Parsedown;

add_filter('Flynt/addComponentData?name=ListComponents', function ($data) {
    if (!empty($data['componentBlocks'])) {
        $data['componentBlocks'] = array_map(function ($block) {
            $block['component'] = substr($block['component'], strpos($block['component'], 'Components/'));

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
                $readmeLines = explode(PHP_EOL, Parsedown::instance()->setUrlsLinked(false)->text(file_get_contents($readme)));
                $block['readme'] = [
                    'title' => strip_tags($readmeLines[0]),
                    'description' => implode(PHP_EOL, array_slice($readmeLines, 1))
                ];
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

function parseComponentReadme($file)
{
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
                'label' => 'Component Blocks',
                'name' => 'componentBlocks',
                'type' => 'repeater',
                'collapsed' => 0,
                'min' => 1,
                'layout' => 'table',
                'button_label' => 'Add Component Block',
                'sub_fields' => [
                    [
                        'label' => 'Component',
                        'name' => 'component',
                        'type' => 'select',
                        'ui' => 1,
                        'ajax' => 0,
                        'choices' => [],
                        'wrapper' => [
                            'width' => 50
                        ]
                    ],
                    [
                        'label' => 'Calls To Action',
                        'name' => 'ctas',
                        'type' => 'group',
                        'collapsed' => 0,
                        'layout' => 'row',
                        'sub_fields' => [
                            [
                                'label' => 'Preview',
                                'name' => 'primary',
                                'type' => 'text'
                            ],
                            [
                                'label' => 'GitHub',
                                'name' => 'secondary',
                                'type' => 'url'
                            ]
                        ]
                    ]
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

Options::addTranslatable('ListComponents', [
    [
        'label' => 'Labels',
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => false
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Code',
                'name' => 'code',
                'type' => 'text',
                'default_value' => 'Code',
                'required' => 1,
            ],
            [
                'label' => 'Preview',
                'name' => 'preview',
                'type' => 'text',
                'default_value' => 'Preview',
                'required' => 1,
            ]
        ],
    ]
]);
