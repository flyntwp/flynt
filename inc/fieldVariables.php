<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getTheme()
{
    return [
        'label' => __('Theme', 'flynt'),
        'name' => 'theme',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => __('(none)', 'flynt'),
            'light' => __('Light', 'flynt'),
            'dark' => __('Dark', 'flynt'),
            'hero' => __('Hero', 'flynt'),
        ]
    ];
}

function getRawSvg()
{
    return [
        'label' => __('Raw SVG', 'flynt'),
        'instructions' => sprintf(
            'Insert raw svg e. g. from <a ref="%1$s" target="_blank">%1$s</a>',
            'https://heroicons.com/'
        ),
        'name' => 'rawSvg',
        'type' => 'textarea',
        'required' => 1,
        'rows' => 1,
        'new_lines' => '',
    ];
}
