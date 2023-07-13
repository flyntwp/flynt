<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getTheme($default = '')
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
        ],
        'default_value' => $default,
    ];
}


function getSize($default = 'medium')
{
    return [
        'label' => __('Size', 'flynt'),
        'name' => 'size',
        'type' => 'radio',
        'other_choice' => 0,
        'save_other_choice' => 0,
        'layout' => 'horizontal',
        'choices' => [
            'medium' => __('Medium', 'flynt'),
            'wide' => __('Wide', 'flynt)'),
            'full' => __('Full', 'flynt'),
        ],
        'default_value' => $default
    ];
}
