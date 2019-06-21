<?php

namespace Flynt\Archives;

use Flynt\Utils\Options;
use Flynt\Api;

const POST_TYPES = [
    'post' => 'Posts'
];

add_action('Flynt/afterRegisterComponents', function () {

    foreach (POST_TYPES as $postType => $label) {
        Options::addTranslatable("{$label}Archive", [
            [
                'label' => 'Grid: Posts',
                'name' => 'gridPosts',
                'type' => 'group',
                'sub_fields' => Api::loadFields('GridPosts', 'layout.sub_fields'),
            ],
        ], 'feature');
    };
}, 11);
