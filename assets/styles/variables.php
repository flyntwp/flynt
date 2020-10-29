<?php

/**
 * Define theme variables.
 */

namespace Flynt\Variables;

function getSizes()
{
    return [
        'container-max-width' => [
            'label' => __('Container Max Width', 'flynt'),
            'default' => 1440,
            'unit' => 'px',
            'options' => [
                'min' => 700,
                'max' => 1600,
                'step' => 1,
            ],
        ],
        'container-padding-desktop' => [
            'label' => __('Container Padding Desktop', 'flynt'),
            'default' => 64,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 128,
                'step' => 1,
            ],
        ],
        'container-padding-tablet' => [
            'label' => __('Container Padding Tablet', 'flynt'),
            'default' => 32,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 64,
                'step' => 1,
            ],
        ],
        'container-padding-mobile' => [
            'label' => __('Container Padding Mobile', 'flynt'),
            'default' => 16,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 32,
                'step' => 1,
            ],
        ],
        'content-max-width' => [
            'label' => __('Content Max Width', 'flynt'),
            'default' => 690,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 1440,
                'step' => 1,
            ],
        ],
        'content-max-width-large' => [
            'label' => __('Content Max Width Large', 'flynt'),
            'default' => 860,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 1440,
                'step' => 1,
            ],
        ],
        'component-spacing-desktop' => [
            'label' => __('Component Spacing Desktop', 'flynt'),
            'default' => 128,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 128,
                'step' => 1,
            ],
        ],
        'component-spacing-tablet' => [
            'label' => __('Component Spacing Tablet', 'flynt'),
            'default' => 96,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 128,
                'step' => 1,
            ],
        ],
        'component-spacing-mobile' => [
            'label' => __('Component Spacing Mobile', 'flynt'),
            'default' => 48,
            'unit' => 'px',
            'options' => [
                'min' => 0,
                'max' => 96,
                'step' => 1,
            ],
        ],
        'gutter-width' => [
            'label' => __('Gutter Width', 'flynt'),
            'default' => 24,
            'unit' => 'px',
            'options' => [
                'min' => 4,
                'max' => 24,
                'step' => 4,
            ],
        ],
    ];
}

function getColors()
{
    return [
        'default' => [
            'label' => __('Default', 'flynt'),
            'colors' => [
                'accent' => [
                    'label' => __('Accent', 'flynt'),
                    'default' => '#2b44df',
                    'hsl' => 1,
                ],
                'headline' => [
                    'label' => __('Headline', 'flynt'),
                    'default' => '#252525',
                ],
                'text' => [
                    'label' => __('Text', 'flynt'),
                    'default' => '#353535',
                ],
                'border' => [
                    'label' => __('Border', 'flynt'),
                    'default' => '#8791BA',
                    'hsl' => 1,
                ],
                'background' => [
                    'label' => __('Background', 'flynt'),
                    'default' => '#ffffff',
                ],
            ],
        ],
        'light' => [
            'label' => __('Theme Light', 'flynt'),
            'colors' => [
                'accent' => [
                    'label' => __('Accent', 'flynt'),
                    'default' => '#2b44df',
                    'hsl' => 1,
                ],
                'headline' => [
                    'label' => __('Headline', 'flynt'),
                    'default' => '#252525',
                ],
                'text' => [
                    'label' => __('Text', 'flynt'),
                    'default' => '#353535',
                ],
                'border' => [
                    'label' => __('Border', 'flynt'),
                    'default' => '#8791BA',
                    'hsl' => 1,
                ],
                'background' => [
                    'label' => __('Background', 'flynt'),
                    'default' => '#F8F9FD',
                ],
            ],
        ],
        'dark' => [
            'label' => __('Theme Dark', 'flynt'),
            'colors' => [
                'accent' => [
                    'label' => __('Accent', 'flynt'),
                    'default' => '#ffffff',
                    'hsl' => 1,
                ],
                'headline' => [
                    'label' => __('Headline', 'flynt'),
                    'default' => '#FBFBFB',
                ],
                'text' => [
                    'label' => __('Text', 'flynt'),
                    'default' => '#E9E9EC',
                ],
                'border' => [
                    'label' => __('Border', 'flynt'),
                    'default' => '#C3C4F7',
                    'hsl' => 1,
                ],
                'background' => [
                    'label' => __('Background', 'flynt'),
                    'default' => '#10205A',
                ],
            ],
        ],
        'hero' => [
            'label' => __('Theme Hero', 'flynt'),
            'colors' => [
                'accent' => [
                    'label' => __('Accent', 'flynt'),
                    'default' => '#ffffff',
                    'hsl' => 1,
                ],
                'headline' => [
                    'label' => __('Headline', 'flynt'),
                    'default' => '#FBFBFB',
                ],
                'text' => [
                    'label' => __('Text', 'flynt'),
                    'default' => '#E9E9EC',
                ],
                'border' => [
                    'label' => __('Border', 'flynt'),
                    'default' => '#CDE2FD',
                    'hsl' => 1,
                ],
                'background' => [
                    'label' => __('Background', 'flynt'),
                    'default' => '#2B44DF',
                ],
            ],
        ],
    ];
}
