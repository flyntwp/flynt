<?php

namespace Flynt\Components\FormNewsletterMailchimp;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('FormNewsletterMailchimp', [
    'layout' => [
        'name' => 'formNewsletterMailchimp',
        'label' => 'Form: Newsletter Mailchimp',
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
                'required' => 1,
                'wrapper' => [
                    'class' => 'autosize',
                ]
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

Options::addTranslatable('FormNewsletterMailchimp', [
    [
        'label' => 'Email Placeholder',
        'name' => 'emailPlaceholder',
        'type' => 'text',
        'required' => 0,
        'default_value' => 'Enter your email'
    ],
    [
        'label' => 'Email Label',
        'name' => 'emailLabel',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Email'
    ],
    [
        'label' => 'Submit Button',
        'name' => 'submitButton',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Submit'
    ]
]);
