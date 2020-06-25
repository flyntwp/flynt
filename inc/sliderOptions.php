<?php

use Flynt\Utils\Options;

Options::addTranslatable('SliderOptions', [
    [
        'label' => 'Accessibility',
        'name' => 'a11y',
        'type' => 'group',
        'instructions' => 'Text labels for screen readers.',
        'sub_fields' => [
            [
                'label' => 'Next Slide Button Text',
                'name' => 'nextSlideMessage',
                'type' => 'text',
                'default_value' => 'Next Slide',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Previous Slide Button Text',
                'name' => 'prevSlideMessage',
                'type' => 'text',
                'default_value' => 'Previous Slide',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'First Slide Text',
                'name' => 'firstSlideMessage',
                'type' => 'text',
                'instructions' => 'Text for previous button when swiper is on first slide.',
                'default_value' => 'This is the first slide',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Last Slide Text',
                'name' => 'lastSlideMessage',
                'type' => 'text',
                'instructions' => 'Text for previous button when swiper is on last slide.',
                'default_value' => 'This is the last slide',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => 'Pagination Bullet Message',
                'name' => 'paginationBulletMessage',
                'type' => 'text',
                'instructions' => '`{{index}}` will be replaced for the slide number.',
                'default_value' => 'Go to slide {{index}}',
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
