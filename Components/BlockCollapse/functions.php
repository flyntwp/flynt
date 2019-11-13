<?php

namespace Flynt\Components\BlockCollapse;

function getACFLayout()
{
    return [
        'name' => 'BlockCollapse',
        'label' => 'Block: Collapse',
        'sub_fields' => [
            [
                [
                    'label' => 'Collapse Component Spacing',
                    'name' => 'message',
                    'type' => 'message',
                    'message' => "The collapse block reduces the vertical space between components.\nSimply move the component in between components with same color themes.",
                    'new_lines' => 'wpautop',
                    'esc_html' => 1
                ]
            ],
        ]
    ];
}
