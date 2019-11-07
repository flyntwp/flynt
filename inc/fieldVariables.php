<?php
/**
 * Defines field variables to be used across multiple components.
 */
namespace Flynt\FieldVariables;

use Flynt\Api;

Api::registerFields('FieldVariables', [
    'theme' => [
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
    ],
    'icon' => [
        'label' => 'Icon',
        'name' => 'icon',
        'type' => 'text',
        'instructions' => 'Enter a valid icon name from Feather Icons (e.g. `check-circle`). Visit https://feathericons.com/ to see the all icons with their corresponding names.',
        'required' => 1
    ],
]);
