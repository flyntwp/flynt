<?php

use Flynt\Utils\Options;

Options::addTranslatable('SliderOptions', [
    [
        'label' => __('Accessibility', 'flynt'),
        'instructions' => __('Text labels for screen readers.', 'flynt'),
        'name' => 'a11y',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Next Slide Button Text', 'flynt'),
                'name' => 'nextSlideMessage',
                'type' => 'text',
                'default_value' => __('Next Slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Previous Slide Button Text', 'flynt'),
                'name' => 'prevSlideMessage',
                'type' => 'text',
                'default_value' => __('Previous Slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('First Slide Text', 'flynt'),
                'instructions' => __('Text for previous button when swiper is on first slide.', 'flynt'),
                'name' => 'firstSlideMessage',
                'type' => 'text',
                'default_value' => __('This is the first slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Last Slide Text', 'flynt'),
                'instructions' => __('Text for previous button when swiper is on last slide.', 'flynt'),
                'name' => 'lastSlideMessage',
                'type' => 'text',
                'default_value' => __('This is the last slide', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Pagination Bullet Message', 'flynt'),
                'instructions' => '`{{index}}` will be replaced for the slide number.',
                'name' => 'paginationBulletMessage',
                'type' => 'text',
                'default_value' => __('Go to slide {{index}}', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
