<?php

namespace Flynt\Components\AccordionDefault;

use Flynt\Api;

Api::registerFields('AccordionDefault', [
    'layout' => [
        'name' => 'AccordionDefault',
        'label' => 'Accordion: Default',
        'sub_fields' => [
            [
                'label' => 'Accordion Panels',
                'name' => 'accordionPanels',
                'type' => 'repeater',
                'layout' => 'row',
                'min' => 1,
                'button_label' => 'Add Accordion Panel',
                'sub_fields' => [
                    [
                        'label' => 'General',
                        'name' => 'generalTab',
                        'type' => 'tab',
                        'placement' => 'top',
                        'endpoint' => 0
                    ],
                    [
                        'label' => 'Panel Title',
                        'name' => 'panelTitle',
                        'type' => 'text'
                    ],
                    [
                        'label' => 'Panel Content',
                        'name' => 'panelContent',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'media_upload' => false,
                        'delay' => true,
                        'wrapper' => [
                            'class' => 'autosize',
                        ],
                    ],
                    [
                        'label' => 'Options',
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
                            Api::loadFields('FieldVariables', 'theme')
                        ]
                    ]
                ],
            ],
        ],
    ],
]);
