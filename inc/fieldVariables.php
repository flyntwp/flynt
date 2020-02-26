<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getTheme()
{
    return [
        'label' => 'Theme',
        'name' => 'theme',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => '(none)',
            'themeLight' => 'Light',
            'themeDark' => 'Dark',
            'themeHero' => 'Hero'
        ]
    ];
}

function getIcon()
{
    return [
        'label' => 'Icon',
        'name' => 'icon',
        'type' => 'text',
        'instructions' => 'Enter a valid icon name from <a href="https://feathericons.com">Feather Icons</a> (e.g. `check-circle`).',
        'required' => 1
    ];
}
