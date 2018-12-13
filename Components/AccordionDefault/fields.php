<?php

Flynt\registerFields('AccordionDefault', [
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
                        'label' => 'Panel Title',
                        'name' => 'panelTitle',
                        'type' => 'text'
                    ],
                    [
                        'label' => 'Panel Content',
                        'name' => 'panelContent',
                        'type' => 'wysiwyg',
                        'tabs' => 'visual,text',
                        'toolbar' => 'full',
                        'media_upload' => false,
                        'delay' => true,
                    ],
                ],
            ],
        ],
    ],
]);

