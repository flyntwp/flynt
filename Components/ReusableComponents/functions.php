<?php

namespace Flynt\Components\ReusableComponents;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ReusableComponents', function ($data) {
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
        'name' => 'reusableComponents',
        'label' => 'Reusable: Components',
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
                'instructions' => 'Select reusable components. Manage <a href="/wp/wp-admin/edit.php?post_type=reusable-component">reusable components</a>.'
            ],
        ]
    ];
}
