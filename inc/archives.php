<?php

namespace Flynt\Archives;

use Flynt\Utils\Options;
use Flynt\Api;
use function Flynt\Components\GridPosts\loadFields;

const POST_TYPES = [
    'post' => [
        'label' => 'Posts',
        'filterByTaxonomy' => 'category',
    ],
];

add_action('Flynt/afterRegisterComponents', function () {

    foreach (POST_TYPES as $postType => $config) {
        Options::addTranslatable("{$config['label']}Archive", [
            [
                'label' => 'Grid: Posts',
                'name' => 'gridPosts',
                'type' => 'group',
                'sub_fields' => loadFields($config['filterByTaxonomy']),
            ],
        ], 'feature');
    };
}, 11);
