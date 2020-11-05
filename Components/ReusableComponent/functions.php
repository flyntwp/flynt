<?php

namespace Flynt\Components\ReusableComponent;

function getACFLayout()
{
    return [
        'name' => 'ReusableComponent',
        'label' => 'Reusable <i class="dashicons dashicons-controls-repeat"></i>',
        'sub_fields' => [
            [
                'label' => __('Select Reusable Components', 'flynt'),
                'name' => 'reusablePost',
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

add_filter('acf/prepare_field/name=reusablePost', function ($field) {
    // Set initial instructions and update with selected post link
    $reusableAdminLink = admin_url('edit.php?post_type=reusable-component');
    $postEditLink = get_edit_post_link($field['value']);
    $postTitle = get_the_title($field['value']);
    $postId = $field['value'] ? $field['value'] : get_the_ID();

    $instructions = sprintf(_x('Add %sreusable components%s.', '%s: start and end of <a> tag', 'flynt'), "<a href=\"${reusableAdminLink}\" target=\"_blank\" rel=\"noopener noreferrer\">", "</a>");
    $editLink = sprintf(_x(' Edit %s.', '%s: Link and title of selected reusable-post', 'flynt'), "<a class=\"reusable-postLink\" data-postId=\"${postId}\" href=\"${postEditLink}\" target=\"_blank\" rel=\"noopener noreferrer\">${postTitle}</a>");

    if ($field['value']) {
        $instructions .= $editLink;
    } else {
        $instructions .= "<span hidden>${editLink}</span>";
    }

    $field['instructions'] = $instructions;
    return $field;
}, 1);
