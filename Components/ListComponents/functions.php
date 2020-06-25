<?php

namespace Flynt\Components\ListComponents;

use Flynt\FieldVariables;
use Flynt\ComponentManager;
use Flynt\Utils\Options;
use Flynt\Utils\Asset;
use Parsedown;

add_filter('Flynt/addComponentData?name=ListComponents', function ($data) {
    if (!empty($data['componentBlocks'])) {
        $templatePaths = [
            'dir' => trailingslashit(get_template_directory()),
            'uri' => trailingslashit(get_template_directory_uri()),
        ];
        $data['componentBlocks'] = array_map(function ($block) use ($templatePaths) {
            $block['component'] = substr($block['component'], strpos($block['component'], 'Components/'));

            $imagePath = $templatePaths['dir'] . $block['component'] . 'screenshot.png';
            if (file_exists($imagePath)) {
                $src = $templatePaths['uri'] . $block['component'] . 'screenshot.png';
                list($width, $height) = getimagesize($imagePath);

                $block['componentScreenshot'] = [
                    'src' => $src,
                    'aspect' => $width / $height
                ];
            }

            $readme = $templatePaths['dir'] . $block['component'] . 'README.md';

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

function getACFLayout()
{
    return [
        'name' => 'listComponents',
        'label' => 'List: Components',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'tabs' => 'visual,text',
                'media_upload' => 0,
                'delay' => 1,
                'instructions' => __('Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.', 'flynt'),
            ],
            [
                'label' => __('Component Blocks', 'flynt'),
                'name' => 'componentBlocks',
                'type' => 'repeater',
                'collapsed' => 0,
                'min' => 1,
                'layout' => 'table',
                'button_label' => __('Add Component Block', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Component', 'flynt'),
                        'name' => 'component',
                        'type' => 'select',
                        'ui' => 1,
                        'ajax' => 0,
                        'choices' => [],
                        'wrapper' => [
                            'width' => 50
                        ],
                    ],
                    [
                        'label' => __('Calls To Action', 'flynt'),
                        'name' => 'ctas',
                        'type' => 'group',
                        'collapsed' => 0,
                        'layout' => 'row',
                        'sub_fields' => [
                            [
                                'label' => __('Preview', 'flynt'),
                                'name' => 'primary',
                                'type' => 'text'
                            ],
                            [
                                'label' => __('GitHub', 'flynt'),
                                'name' => 'secondary',
                                'type' => 'url'
                            ],
                        ],
                    ],
                ],
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
                    FieldVariables\getTheme(),
                ],
            ]
        ]
    ];
}

Options::addTranslatable('ListComponents', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Code', 'flynt'),
                'name' => 'code',
                'type' => 'text',
                'default_value' => 'Code',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Preview', 'flynt'),
                'name' => 'preview',
                'type' => 'text',
                'default_value' => 'Preview',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ]
]);
