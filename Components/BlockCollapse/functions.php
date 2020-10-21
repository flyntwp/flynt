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
                    'message' => __('<b>Full</b> option to removes space between same colored themed components. <br><b>Small</b> option reduces space to 64px between components and 32px on mobile regardless of the theme.', 'flynt'),
                    'new_lines' => 'wpautop',
                ]
            ],
            [
                'label' => __('Collapse Level', 'flynt'),
                'name' => 'collapseLevel',
                'type' => 'button_group',
                'choices' => [
                    'small' => __('Small', 'flynt'),
                    'full' => __('Full', 'flynt'),
                ],
                'default_value' => 'half',
            ],
        ]
    ];
}
