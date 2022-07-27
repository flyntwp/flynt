<?php

namespace Flynt\Components\BlockCollapse;

add_filter('Flynt/addComponentData?name=BlockCollapse', function ($data) {
    $data['status'] = $data['percentageDistance'] >= 100 ? 'expand' : 'collapse';
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockCollapse',
        'label' => 'Block: Collapse',
        'sub_fields' => [
            [
                'label' => __('Vertical space', 'flynt'),
                'instructions' => __('Distance adjusts the vertical space between two components.', 'flynt'),
                'name' => 'percentageDistance',
                'type' => 'range',
                'prepend' => __('Distance', 'flynt'),
                'append' => __('%', 'flynt'),
                'default_value' => 0,
                'min' => 0,
                'max' => 200,
                'wrapper' =>  [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Examples', 'flynt'),
                'name' => '',
                'type' => 'message',
                'message' => sprintf(
                    '%1$s' . PHP_EOL . '%2$s' . PHP_EOL . '%3$s',
                    __('0% (Default) no spacing between components', 'flynt'),
                    __('50% reduces vertical space (by half)', 'flynt'),
                    __('150% extends vertical space (by 50%)', 'flynt')
                ),
                'new_lines' => 'wpautop',
                'esc_html' => 1,
                'wrapper' =>  [
                    'width' => '50',
                ],
            ],
        ]
    ];
}
