<?php

use ACFComposer\ACFComposer;
use Flynt\Api;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Components',
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => 'Page Components',
                'type' => 'flexible_content',
                'button_label' => 'Add Component',
                'layouts' => [
                    Api::loadFields('BlockCollapse', 'layout'),
                    Api::loadFields('BlockImage', 'layout'),
                    Api::loadFields('BlockImageText', 'layout'),
                    Api::loadFields('BlockVideoOembed', 'layout'),
                    Api::loadFields('BlockWysiwyg', 'layout'),
                    Api::loadFields('GridImageText', 'layout'),
                    Api::loadFields('GridPostsLatest', 'layout'),
                    Api::loadFields('ListComponents', 'layout'),
                    Api::loadFields('SliderImages', 'layout'),
                ]
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                ],
                [
                    'param' => 'page_type',
                    'operator' => '!=',
                    'value' => 'posts_page'
                ]
            ]
        ]
    ]);
});
