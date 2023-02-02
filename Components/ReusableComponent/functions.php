<?php

namespace Flynt\Components\ReusableComponent;

function getACFLayout()
{
    return [
        'name' => 'ReusableComponent',
        'label' => sprintf('%1$s <i class="dashicons dashicons-controls-repeat"></i>', __('Reusable', 'flynt')),
        'sub_fields' => [
            [
                'label' => __('Select Reusable Component', 'flynt'),
                'name' => 'reusableComponent',
                'type' => 'post_object',
                'post_type' => [
                    'reusable-components'
                ],
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 1,
                'required' => 1,
                'return_format' => 'object',
            ],
        ],
    ];
}

add_filter('acf/prepare_field/name=reusableComponent', function ($field) {
    $reusableAdminLink = admin_url('edit.php?post_type=reusable-components');
    $postEditLink = get_edit_post_link($field['value']);
    $postTitle = get_the_title($field['value']);
    $postId = $field['value'] ? $field['value'] : get_the_ID();

    $instructions = sprintf(
        /* translators: 1: <a> element 2: </a> element */
        __('Add %1$sreusable component%2$s.', 'flynt'),
        "<a href='${reusableAdminLink}' target='_blank' rel='noopener noreferrer'>",
        "</a>"
    );
    $editLink = sprintf(
        /* translators: %s: Link and title of selected reusable-post */
        __(' Edit %s.', 'flynt'),
        "<a class='reusable-postLink' data-postId='${postId}' href='${postEditLink}' target='_blank' rel='noopener noreferrer'>${postTitle}</a>"
    );

    if ($field['value']) {
        $instructions .= $editLink;
    } else {
        $instructions .= "<span hidden>${editLink}</span>";
    }

    $field['instructions'] = $instructions;
    return $field;
}, 1);
