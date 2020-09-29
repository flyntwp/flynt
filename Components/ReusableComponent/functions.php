<?php

namespace Flynt\Components\ReusableComponent;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=ReusableComponent', function ($data) {
    if (!empty($data['reusableId'])) {
        $data['post'] = Timber::get_post($data['reusableId']);
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'ReusableComponent',
        'label' => '<i class="dashicons dashicons-controls-repeat"></i> Reusable',
        'sub_fields' => [
            [
                'label' => __('Select Component Set', 'flynt'),
                'name' => 'reusableId',
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
        ],
    ];
}

add_filter('acf/prepare_field/name=reusableId', function ($field) {
    // Update instructions with selected post link
    if ($field['value']) {
        $postTitle = get_the_title($field['value']);
        $instructions = $field['instructions'];
        $instructions = 'Edit <a class="reusable-postLink" href="/wp/wp-admin/post.php?post=' . $field['value'] . '&action=edit&classic-editor" target="_blank" rel="noopener noreferrer">' . $postTitle . '</a>.';
        $field['instructions'] = $instructions;
    }
    return $field;
});
