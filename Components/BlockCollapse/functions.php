<?php

namespace Flynt\Components\BlockCollapse;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BlockCollapse', function ($data) {
    $data['status'] = $data['percentageDistance'] >= 101 ? 'expand' : 'collapse';
    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockCollapse',
        'label' => __('Block: Collapse', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Vertical space', 'flynt'),
                'instructions' => __('Distance adjusts the vertical space between two components.', 'flynt'),
                'name' => 'percentageDistance',
                'type' => 'range',
                'prepend' => __('Distance', 'flynt'),
                'append' => __('%', 'flynt'),
                'default_value' => 50,
                'min' => 0,
                'max' => 200,
                'step' => 50,
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
                    __('0% no spacing between components', 'flynt'),
                    __('50% reduces vertical space (by half)', 'flynt'),
                    __('150% extends vertical space (by 50%)', 'flynt')
                ),
                'new_lines' => 'wpautop',
                'esc_html' => 1,
                'wrapper' =>  [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getTheme(),
                ]
            ]
        ]
    ];
}
