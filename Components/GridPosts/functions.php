<?php

namespace Flynt\Components\GridPosts;

use Flynt\Utils\Component;
use Flynt;

add_filter('Flynt/addComponentData?name=GridPosts', function ($data) {
    Component::enqueueAssets('GridPosts');

    return $data;
}, 10, 2);

use Flynt\Utils\Options;

Flynt\registerFields('GridPosts', [
    'layout' => [
        'name' => 'gridPosts',
        'label' => 'Grid: Posts',
        'sub_fields' => [
            [
                'label' => 'Pre-Content',
                'name' => 'preContentHtml',
                'type' => 'wysiwyg',
                'instructions' => 'Want to add a headline? And a paragraph? Go ahead! Or just leave it empty and nothing will be shown.',
                'tabs' => 'visual,text',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ],
            ]
        ]
    ]
]);

Options::addTranslatable('GridPosts', [
    [
        'name' => 'previousLabel',
        'label' => 'Previous Label',
        'type' => 'text',
        'default_value' => 'Previous',
        'required' => 1
    ],
    [
        'name' => 'nextLabel',
        'label' => 'Next Label',
        'type' => 'text',
        'default_value' => 'Next',
        'required' => 1
    ],
    [
        'name' => 'noPostsFoundText',
        'label' => 'No Posts Found Text',
        'type' => 'text',
        'default_value' => 'No posts found.',
        'required' => 1
    ]
]);
