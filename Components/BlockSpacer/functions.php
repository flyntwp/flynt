<?php

namespace Flynt\Components\BlockSpacer;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BlockSpacer', function (array $data): array {
    $data['status'] = $data['options']['percentageDistance'] >= 101 ? 'expand' : 'collapse';
    return $data;
});

function getACFLayout(): array
{
    return [
        'name' => 'blockSpacer',
        'label' => __('Block: Spacer', 'flynt'),
        'sub_fields' => [
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
                    [
                        'label' => __('Vertical space', 'flynt'),
                        'instructions' => __('Distance between two components.', 'flynt'),
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
                        'new_lines' => 'br',
                        'esc_html' => 1,
                        'wrapper' =>  [
                            'width' => '50',
                        ],
                    ],
                ]
            ]
        ]
    ];
}
