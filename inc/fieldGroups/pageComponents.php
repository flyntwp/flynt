<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

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
                    Components\BlockCollapse\getLayout(),
                    Components\BlockImage\getLayout(),
                    Components\BlockImageText\getLayout(),
                    Components\BlockVideoOembed\getLayout(),
                    Components\BlockWysiwyg\getLayout(),
                    Components\GridImageText\getLayout(),
                    Components\GridPostsLatest\getLayout(),
                    Components\ListComponents\getLayout(),
                    Components\SliderImages\getLayout(),
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
