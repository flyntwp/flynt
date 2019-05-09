<?php

use ACFComposer\ACFComposer;
use Flynt\Api;
use Flynt\Defaults;

add_action('Flynt/afterRegisterComponents', function () {
    $layouts = [
        Api::loadFields('BlockImage', 'layout'),
        Api::loadFields('BlockWysiwyg', 'layout'),
    ];

    if (!Defaults::$useGutenberg) {
        ACFComposer::registerFieldGroup([
            'name' => 'postComponents',
            'title' => 'Post Components',
            'style' => 'seamless',
            'fields' => [
                [
                    'name' => 'postComponents',
                    'label' => 'Post Components',
                    'type' => 'flexible_content',
                    'button_label' => 'Add Component',
                    'layouts' => $layouts,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ],
                ],
            ],
        ]);
    } else {
        API::registerBlocks($layouts);
    }
});
