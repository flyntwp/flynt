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
                    'full' => __('Full', 'flynt'),
                    'medium' => __('Medium', 'flynt'),
                    'small' => __('Small', 'flynt'),
                ],
                'default_value' => 'none',
            ],
        ]
    ];
}
