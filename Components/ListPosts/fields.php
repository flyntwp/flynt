<?php

use Flynt\Utils\Options;

Flynt\registerFields('ListPosts', [
    'layout' => [
        'name' => 'listPosts',
        'label' => 'List Posts'
    ]
]);


Options::addTranslatable('ListPosts', [
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
        'name' => 'readMoreLabel',
        'label' => 'Read More Label',
        'type' => 'text',
        'default_value' => 'Read More',
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
