<?php

use ACFComposer\ACFComposer;
use Flynt\SetComponents;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'reusableComponents',
        'title' => 'Reusable Components',
        'style' => 'seamless',
        'menu_order' => 1,
        'fields' => [
            [
                'name' => 'reusableComponents',
                'label' => 'Reusable Components',
                'type' => 'flexible_content',
                'button_label' => 'Add Component',
                'layouts' => SetComponents\getReusableComponents(),
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'reusable-component'
                ],
            ]
        ]
    ]);
});
