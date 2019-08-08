<?php

namespace Flynt\Components\FormContactForm7;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('FormContactForm7', [
    'layout' => [
        'name' => 'FormContactForm7',
        'label' => 'Form: Contact Form 7',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'Tab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
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
                'label' => 'Form Id',
                'name' => 'formId',
                'type' => 'post_object',
                'post_type' => [
                    'wpcf7_contact_form'
                ],
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
                'required' => 1,
            ],
            [
                'name' => 'contentFooterHtml',
                'label' => 'Content Footer',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'full',
                'required' => 0,
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
