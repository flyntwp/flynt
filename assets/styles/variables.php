<?php

/**
 * Define theme variables.
 */

namespace Flynt\Variables;

function getVariables()
{
    return [
        [
            'label' => __('Typography', 'flynt'),
            'name' => 'typo',
            'type' => 'section',
            'priority' => 160,
            'fields' => [
                [
                    'label' => __('Heading 1', 'flynt'),
                    'name' => 'h1-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Encode Sans Semi Condensed',
                        'category' => 'sans-serif',
                        'variant' => '800',
                    ],
                ],
                [
                    'label' => __('Heading 2', 'flynt'),
                    'name' => 'h2-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Encode Sans Semi Condensed',
                        'category' => 'sans-serif',
                        'variant' => '800',
                    ],
                ],
                [
                    'label' => __('Heading 3', 'flynt'),
                    'name' => 'h3-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Encode Sans Semi Condensed',
                        'category' => 'sans-serif',
                        'variant' => '700',
                    ],
                ],
                [
                    'label' => __('Heading 4', 'flynt'),
                    'name' => 'h4-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Encode Sans Semi Condensed',
                        'category' => 'sans-serif',
                        'variant' => '700',
                    ],
                ],
                [
                    'label' => __('Heading 5', 'flynt'),
                    'name' => 'h5-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Roboto',
                        'category' => 'sans-serif',
                        'variant' => '400',
                    ],
                ],
                [
                    'label' => __('Heading 6', 'flynt'),
                    'name' => 'h6-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Roboto',
                        'category' => 'sans-serif',
                        'variant' => '500',
                    ],
                ],
                [
                    'label' => __('Body Regular', 'flynt'),
                    'name' => 'body-regular-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 1,
                    'default' => [
                        'family' => 'Roboto',
                        'category' => 'sans-serif',
                        'variant' => '400',
                    ],
                ],
                [
                    'label' => __('Body Bold', 'flynt'),
                    'name' => 'body-bold-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 1,
                    'default' => [
                        'family' => 'Roboto',
                        'category' => 'sans-serif',
                        'variant' => '700',
                    ],
                ],
                [
                    'label' => __('Elements', 'flynt'),
                    'description' => __('Buttons, links, menu, labels, meta.', 'flynt'),
                    'name' => 'elements-font',
                    'type' => 'flynt-typography',
                    'fallback' => 'Helvetica, Arial',
                    'italic' => 0,
                    'default' => [
                        'family' => 'Roboto',
                        'category' => 'sans-serif',
                        'variant' => '500',
                    ],
                ],
            ],
        ],
        [
            'label' => __('Sizes', 'flynt'),
            'name' => 'sizes',
            'type' => 'section',
            'priority' => 160,
            'fields' => [
                [
                    'label' => __('Component Spacing', 'flynt'),
                    'description' => __('The selected value is the base spacing used on mobile. On tablet and desktop the spacing is proportionally increased.', 'flynt'),
                    'name' => 'component-spacing-base',
                    'type' => 'flynt-range',
                    'default' => 48,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 30,
                        'max' => 96,
                        'step' => 3,
                    ],
                ],
                [
                    'label' => __('Box Spacing', 'flynt'),
                    'name' => 'box-spacing',
                    'type' => 'flynt-range',
                    'default' => 32,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 16,
                        'max' => 48,
                        'step' => 4,
                    ],
                ],
                [
                    'label' => __('Box Border Radius', 'flynt'),
                    'name' => 'box-border-radius',
                    'type' => 'flynt-range',
                    'default' => 16,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 32,
                        'step' => 1,
                    ],
                ],
            ]
        ],
        [
            'label' => __('Colors', 'flynt'),
            'name' => 'colors',
            'type' => 'panel',
            'priority' => 161,
            'sections' => [
                [
                    'label' => __('Default', 'flynt'),
                    'name' => 'default',
                    'type' => 'section',
                    'fields' => [
                        [
                            'label' => __('Accent', 'flynt'),
                            'name' => 'theme-default-color-accent',
                            'type' => 'color',
                            'default' => '#2b44df',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Headline', 'flynt'),
                            'name' => 'theme-default-color-headline',
                            'type' => 'color',
                            'default' => '#252525',
                        ],
                        [
                            'label' => __('Text', 'flynt'),
                            'name' => 'theme-default-color-text',
                            'type' => 'color',
                            'default' => '#353535',
                        ],
                        [
                            'label' => __('Border', 'flynt'),
                            'name' => 'theme-default-color-border',
                            'type' => 'color',
                            'default' => '#8791BA',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Background', 'flynt'),
                            'name' => 'theme-default-color-background',
                            'type' => 'color',
                            'default' => '#ffffff',
                        ],
                    ]
                ],
                [
                    'label' => __('Theme Light', 'flynt'),
                    'name' => 'light',
                    'type' => 'section',
                    'fields' => [
                        [
                            'label' => __('Accent', 'flynt'),
                            'name' => 'theme-light-color-accent',
                            'type' => 'color',
                            'default' => '#2b44df',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Headline', 'flynt'),
                            'name' => 'theme-light-color-headline',
                            'type' => 'color',
                            'default' => '#252525',
                        ],
                        [
                            'label' => __('Text', 'flynt'),
                            'name' => 'theme-light-color-text',
                            'type' => 'color',
                            'default' => '#353535',
                        ],
                        [
                            'label' => __('Border', 'flynt'),
                            'name' => 'theme-light-color-border',
                            'type' => 'color',
                            'default' => '#8791BA',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Background', 'flynt'),
                            'name' => 'theme-light-color-background',
                            'type' => 'color',
                            'default' => '#F8F9FD',
                        ],
                    ]
                ],
                [
                    'label' => __('Theme Dark', 'flynt'),
                    'name' => 'dark',
                    'type' => 'section',
                    'fields' => [
                        [
                            'label' => __('Accent', 'flynt'),
                            'name' => 'theme-dark-color-accent',
                            'type' => 'color',
                            'default' => '#ffc261',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Headline', 'flynt'),
                            'name' => 'theme-dark-color-headline',
                            'type' => 'color',
                            'default' => '#FBFBFB',
                        ],
                        [
                            'label' => __('Text', 'flynt'),
                            'name' => 'theme-dark-color-text',
                            'type' => 'color',
                            'default' => '#E9E9EC',
                        ],
                        [
                            'label' => __('Border', 'flynt'),
                            'name' => 'theme-dark-color-border',
                            'type' => 'color',
                            'default' => '#C3C4F7',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Background', 'flynt'),
                            'name' => 'theme-dark-color-background',
                            'type' => 'color',
                            'default' => '#10205A',
                        ],
                    ]
                ],
                [
                    'label' => __('Theme Hero', 'flynt'),
                    'name' => 'hero',
                    'type' => 'section',
                    'fields' => [
                        [
                            'label' => __('Accent', 'flynt'),
                            'name' => 'theme-hero-color-accent',
                            'type' => 'color',
                            'default' => '#ffc261',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Headline', 'flynt'),
                            'name' => 'theme-hero-color-headline',
                            'type' => 'color',
                            'default' => '#FBFBFB',
                        ],
                        [
                            'label' => __('Text', 'flynt'),
                            'name' => 'theme-hero-color-text',
                            'type' => 'color',
                            'default' => '#E9E9EC',
                        ],
                        [
                            'label' => __('Border', 'flynt'),
                            'name' => 'theme-hero-color-border',
                            'type' => 'color',
                            'default' => '#CDE2FD',
                            'hsl' => 1,
                        ],
                        [
                            'label' => __('Background', 'flynt'),
                            'name' => 'theme-hero-color-background',
                            'type' => 'color',
                            'default' => '#2B44DF',
                        ],
                    ]
                ],
            ]
        ]
    ];
}
