<?php

/**
 * Moves most relevant editor buttons to the first toolbar
 * and provides config for creating new toolbars, block formats, and style formats.
 * See the TinyMce documentation for more information: https://www.tiny.cloud/docs/
 */

namespace Flynt\TinyMce;

// First Toolbar.
add_filter('mce_buttons', function ($buttons) {
    $config = getConfig();
    if ($config && isset($config['toolbars'])) {
        $toolbars = $config['toolbars'];
        if (isset($toolbars['default']) && isset($toolbars['default'][0])) {
            return $toolbars['default'][0];
        }
    }
    return $buttons;
});

// Second Toolbar.
add_filter('mce_buttons_2', '__return_empty_array');

add_filter('tiny_mce_before_init', function ($init) {
    $config = getConfig();
    if ($config) {
        if (isset($config['blockformats'])) {
            $init['block_formats'] = getBlockFormats($config['blockformats']);
        }

        if (isset($config['styleformats'])) {
            // Send it to style_formats as true js array
            $init['style_formats'] = json_encode($config['styleformats']);
        }
    }
    return $init;
});

add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
    // Load Toolbars and parse them into TinyMCE.
    $config = getConfig();
    if ($config && !empty($config['toolbars'])) {
        $toolbars = array_map(function ($toolbar) {
            array_unshift($toolbar, []);
            return $toolbar;
        }, $config['toolbars']);
    }
    return $toolbars;
});

function getBlockFormats($blockFormats)
{
    if (!empty($blockFormats)) {
        $blockFormatStrings = array_map(
            function ($tag, $label) {
                return "{$label}={$tag}";
            },
            $blockFormats,
            array_keys($blockFormats)
        );
        return implode(';', $blockFormatStrings);
    }
    return '';
}

function getConfig()
{
    return [
        'blockformats' => [
            __('Paragraph', 'flynt') => 'p',
            __('Heading 1', 'flynt') => 'h1',
            __('Heading 2', 'flynt') => 'h2',
            __('Heading 3', 'flynt') => 'h3',
            __('Heading 4', 'flynt') => 'h4',
            __('Heading 5', 'flynt') => 'h5',
            __('Heading 6', 'flynt') => 'h6'
        ],
        'styleformats' => [
            [
                'title' => __('Headings', 'flynt'),
                'icon' => '',
                'items' => [
                    [
                        'title' => __('Heading 1', 'flynt'),
                        'classes' => 'h1',
                        'selector' => '*'
                    ],
                    [
                        'title' => __('Heading 2', 'flynt'),
                        'classes' => 'h2',
                        'selector' => '*'
                    ],
                    [
                        'title' => __('Heading 3', 'flynt'),
                        'classes' => 'h3',
                        'selector' => '*'
                    ],
                    [
                        'title' => __('Heading 4', 'flynt'),
                        'classes' => 'h4',
                        'selector' => '*'
                    ],
                    [
                        'title' => __('Heading 5', 'flynt'),
                        'classes' => 'h5',
                        'selector' => '*'
                    ],
                    [
                        'title' => __('Heading 6', 'flynt'),
                        'classes' => 'h6',
                        'selector' => '*'
                    ],
                ]
            ],
            [
                'title' => __('Buttons', 'flynt'),
                'icon' => '',
                'items' => [
                    [
                        'title' => __('Button', 'flynt'),
                        'classes' => 'button',
                        'selector' => 'a,button'
                    ],
                    [
                        'title' => __('Button Outlined', 'flynt'),
                        'classes' => 'button--outlined',
                        'selector' => '.button'
                    ],
                    [
                        'title' => __('Button Text', 'flynt'),
                        'classes' => 'button--text',
                        'selector' => '.button'
                    ],
                ]
            ],
            [
                'title' => __('Paragraph', 'flynt'),
                'classes' => 'paragraph',
                'selector' => '*'
            ]
        ],
        'toolbars' => [
            'default' => [
                [
                    'formatselect',
                    'styleselect',
                    'bold',
                    'italic',
                    'strikethrough',
                    'blockquote',
                    '|',
                    'bullist',
                    'numlist',
                    '|',
                    'link',
                    'unlink',
                    '|',
                    'pastetext',
                    'removeformat',
                    '|',
                    'undo',
                    'redo',
                    'fullscreen'
                ]
            ],
            'basic' => [
                [
                    'bold',
                    'italic',
                    'strikethrough',
                    '|',
                    'link',
                    'unlink',
                    '|',
                    'undo',
                    'redo',
                    'fullscreen'
                ]
            ]
        ]
    ];
}
