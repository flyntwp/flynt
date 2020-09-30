<?php

namespace Flynt\Components\BlockAnchor;

add_filter('Flynt/addComponentData?name=BlockAnchor', function ($data) {
    if (isset($data['anchor'])) {
        $data['anchor'] = sanitize_title($data['anchor']);
    }
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockAnchor',
        'label' => 'Block: Anchor',
        'sub_fields' => [
            [
                [
                    'label' => 'Enter unique name',
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => 'Use latin characters and add a unique name to create an anchor link.'
                ],
                [
                    'label' => 'Your unique anchor link: (select & copy)',
                    'name' => 'anchorLink',
                    'type' => 'text',
                    'readonly' => 1,
                    'wrapper' => [
                        'width' => '80',
                    ],
                ],
                // [
                //     'label' => 'Your unique anchor link: (select & copy)',
                //     'name' => 'anchorLinkMessage',
                //     'type' => 'message',
                //     'message' => '<button class="dashicons dashicons-thumbs-up" data-copy></button>',
                //     'new_lines' => '',
                //     'esc_html' => 0
                // ],
            ],
        ]
    ];
}

add_filter('acf/prepare_field/name=anchorLink', function($field) {
    $anchor = get_field('anchor', get_the_ID());
    $url = get_page_link(get_the_ID());
    var_dump($anchor);
    // var_dump($url);
    // var_dump($field);
    $field['value'] = $url . '#';
    // $field['readonly'] = 1;

    return $field;
});
