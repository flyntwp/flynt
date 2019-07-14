<?php
/**
 * Defines field variables to be used across multiple components.
 */
namespace Flynt;

class FieldVariables
{
    public static $theme = [
        'label' => 'Theme',
        'name' => 'theme',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => '-',
            'themeDefault' => 'Default',
            'themeLight' => 'Light',
            'themeDark' => 'Dark',
            'themeHero' => 'Hero'
        ]
    ];
}
