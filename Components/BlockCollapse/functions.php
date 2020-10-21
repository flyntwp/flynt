<?php

namespace Flynt\Components\BlockCollapse;

function getACFLayout()
{
    return [
        'name' => 'blockCollapse',
        'label' => 'Block: Collapse',
        'sub_fields' => [
            [
                'label' => __('Collapse Component Spacing', 'flynt'),
                'name' => 'collapseLevel',
                'type' => 'button_group',
                'choices' => [
                    'none' => __('None', 'flynt'),
                    'small' => __('Small', 'flynt'),
                    'medium' => __('Medium', 'flynt'),
                ],
                'default_value' => 'none',
            ],
        ]
    ];
}
