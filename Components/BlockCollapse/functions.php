<?php

namespace Flynt\Components\BlockCollapse;

function getACFLayout()
{
    return [
        'name' => 'blockCollapse',
        'label' => 'Block: Collapse',
        'sub_fields' => [
            [
                'label' => __('Collapse Spacing', 'flynt'),
                'name' => 'collapseSpacing',
                'type' => 'button_group',
                'choices' => [
                    'noSpacing' => __('No Spacing', 'flynt'),
                    'preContent' => __('Pre Content', 'flynt'),
                    'paragraph' => __('Paragraph', 'flynt'),
                ],
                'default_value' => 'none',
            ],
        ]
    ];
}
