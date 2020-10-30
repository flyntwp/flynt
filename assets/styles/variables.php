<?php

/**
 * Define theme variables.
 */

namespace Flynt\Variables;

function getVariables()
{
    return [
        [
            'label' => __('Sizes', 'flynt'),
            'name' => 'sizes',
            'type' => 'section',
            'priority' => 160,
            'fields' => [
                [
                    'label' => __('Container Max Width', 'flynt'),
                    'name' => 'container-max-width',
                    'type' => 'range',
                    'default' => 1440,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 700,
                        'max' => 1600,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Container Padding Desktop', 'flynt'),
                    'name' => 'container-padding-desktop',
                    'type' => 'range',
                    'default' => 64,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 240,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Container Padding Tablet', 'flynt'),
                    'name' => 'container-padding-tablet',
                    'type' => 'range',
                    'default' => 32,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 64,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Container Padding Mobile', 'flynt'),
                    'name' => 'container-padding-mobile',
                    'type' => 'range',
                    'default' => 16,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 32,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Content Max Width', 'flynt'),
                    'name' => 'content-max-width',
                    'type' => 'range',
                    'default' => 690,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 1440,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Content Max Width Large', 'flynt'),
                    'name' => 'content-max-width-large',
                    'type' => 'range',
                    'default' => 690,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 1440,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Component Spacing Desktop', 'flynt'),
                    'name' => 'component-spacing-desktop',
                    'type' => 'range',
                    'default' => 128,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 128,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Component Spacing Tablet', 'flynt'),
                    'name' => 'component-spacing-tablet',
                    'type' => 'range',
                    'default' => 96,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 128,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Component Spacing Mobile', 'flynt'),
                    'name' => 'component-spacing-mobile',
                    'type' => 'range',
                    'default' => 48,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 96,
                        'step' => 1,
                    ],
                ],
                [
                    'label' => __('Gutter Width', 'flynt'),
                    'name' => 'gutter-width',
                    'type' => 'range',
                    'default' => 24,
                    'unit' => 'px',
                    'input_attrs' => [
                        'min' => 0,
                        'max' => 48,
                        'step' => 4,
                    ],
                ],
                [
                    'label' => __('Box Spacing', 'flynt'),
                    'name' => 'box-spacing',
                    'type' => 'range',
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
                    'type' => 'range',
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
                            'default' => '#ffffff',
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
                            'default' => '#ffffff',
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
