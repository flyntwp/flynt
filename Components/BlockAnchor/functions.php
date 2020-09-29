<?php

namespace Flynt\Components\BlockAnchor;

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
                    'instructions' => 'Drop Block:Anchor anywhere in the page and create an anchor link from unique name. Use anchor link to scroll to this position.'
                ],
            ],
        ]
    ];
}
