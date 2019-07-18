<?php

namespace Flynt\Components\FormContact;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('FormContact', [
    'layout' => [
        'name' => 'formContact',
        'label' => 'Form: Contact',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'Tab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => 'Text Alignment',
                'name' => 'textAlignment',
                'type' => 'button_group',
                'choices' => [
                    'textLeft' => '<i class=\'dashicons dashicons-editor-alignleft\' title=\'Align text left\'></i>',
                    'textCenter' => '<i class=\'dashicons dashicons-editor-aligncenter\' title=\'Align text center\'></i>'
                ]
            ],
            [
                'name' => 'contentHtml',
                'label' => 'Content',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'full',
                'wrapper' => [
                    'class' => 'autosize',
                ]
            ],
            [
                'label' => 'Text Alignment',
                'name' => 'textAlignmentFooter',
                'type' => 'button_group',
                'choices' => [
                    'textLeft' => '<i class=\'dashicons dashicons-editor-alignleft\' title=\'Align text left\'></i>',
                    'textCenter' => '<i class=\'dashicons dashicons-editor-aligncenter\' title=\'Align text center\'></i>',
                    'textRight' => '<i class=\'dashicons dashicons-editor-alignright\' title=\'Align text right\'></i>'
                ]
            ],
            [
                'name' => 'footerHtml',
                'label' => 'Footer Content',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'full',
                'wrapper' => [
                    'class' => 'autosize',
                ]
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
        ]
    ]
]);

Options::addTranslatable('FormContact', [
    [
       'label' => 'First Name',
       'name' => 'firstName',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'First Name'
    ],
    [
       'label' => 'Last Name',
       'name' => 'lastName',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Last Name'
    ],
    [
       'label' => 'Email',
       'name' => 'email',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Email'
    ],
    [
       'label' => 'Mobile Phone',
       'name' => 'mobilePhone',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Mobile Phone'
    ],
    [
       'label' => 'Company',
       'name' => 'company',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Company'
    ],
    [
       'label' => 'Message',
       'name' => 'message',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Message'
    ],
    [
       'label' => 'ButtonText',
       'name' => 'buttonText',
       'type' => 'text',
       'required' => 1,
       'default_value' => 'Send Message'
    ],
]);
