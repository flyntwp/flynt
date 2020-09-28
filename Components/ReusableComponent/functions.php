<?php

namespace Flynt\Components\ReusableComponent;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ReusableComponent', function ($data) {
    if (!empty($data['id'])) {
        $data['post'] = Timber::get_post($data['id']);
    }
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ReusableComponent',
        'label' => '<i class="dashicons dashicons-controls-repeat"></i> Reusable Component',
        'sub_fields' => [
            [
                'label' => __('Select Component Set', 'flynt'),
                'name' => 'id',
                'type' => 'post_object',
                'post_type' => [
                    'reusable-component'
                ],
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'required' => 1,
                'return_format' => 'id',
                'instructions' => 'Add or edit <a href="/wp/wp-admin/edit.php?post_type=reusable-component">reusable components</a>.'
            ],
        ]
    ];
}
