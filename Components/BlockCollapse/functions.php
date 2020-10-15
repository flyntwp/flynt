<?php

namespace Flynt\Components\BlockCollapse;

function getACFLayout()
{
    return [
        'name' => 'blockCollapse',
        'label' => 'Block: Collapse',
        'sub_fields' => [
            [
                [
                    'label' => __('Collapse Component Spacing', 'flynt'),
                    'name' => 'message',
                    'type' => 'message',
                    'message' => __('The collapse block reduces the vertical space between components. Simply move the component in between components with same color themes.', 'flynt'),
                    'new_lines' => 'wpautop',
                    'esc_html' => 1
                ]
            ],
            [
                'label' => __('Collapse Level', 'flynt'),
                'name' => 'collapseLevel',
                'type' => 'button_group',
                'choices' => [
                    'half' => __('50%', 'flynt'),
                    'full' => __('100%', 'flynt'),
                ],
                'default_value' => 'half'
            ],
        ]
    ];
}
