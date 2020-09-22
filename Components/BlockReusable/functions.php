<?php

namespace Flynt\Components\BlockReusable;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockReusable', function ($data) {
    if (!empty($data['ids'])) {
        $data['posts'] = Timber::get_posts([
            'post_type' => 'reusable-component',
            'post__in' => $data['ids'],
            'orderby' => 'post__in',
        ]);
    }
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockReusable',
        'label' => 'Block: Reusable',
        'sub_fields' => [
            [
                'label' => __('Components', 'flynt'),
                'name' => 'ids',
                'type' => 'post_object',
                'post_type' => [
                    'reusable-component'
                ],
                'allow_null' => 0,
                'multiple' => 1,
                'ui' => 1,
                'required' => 1,
                'return_format' => 'id',
                'instructions' => 'Select reusable posts to show their components. You can manage reusable components <a href="/wp/wp-admin/edit.php?post_type=reusable-component">here</a>.'
            ],
        ]
    ];
}
