<?php

namespace Flynt\Components\GoogleAnalyticsOptIn;

use Flynt\Utils\Options;
use Flynt\Api;

Options::addGlobal('GoogleAnalyticsAndOptInSettings', [
    [
        'label' => 'GA Settings',
        'name' => 'gaSettings',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'name' => 'gaId',
        'label' => 'Google Analytics ID',
        'type' => 'text',
        'maxlength' => 20,
        'prepend' => '',
        'append' => '',
        'placeholder' => 'XX-XXXXXXXX-X',
        'instructions' => 'You can enter \'debug\' to activate debug mode. It will only log to console and overwrite all other settings.'
    ],
    [
        'name' => 'skippedUserRoles',
        'label' => 'Skipped User Roles',
        'type' => 'checkbox',
        'choices' => [
            'administrator' => 'Administrator',
            'editor' => 'Editor',
            'author' => 'Author',
            'contributor' => 'Contributor',
            'subscriber' => 'Subscriber'
        ],
        'toggle' => 'All',
        'allow_custom' => 0,
        'save_custom' => 0,
        'layout' => 'vertical'
    ],
    [
        'name' => 'skippedIps',
        'label' => 'Skipped IPs',
        'type' => 'textarea',
        'maxlength' => 500,
        'placeholder' => 'Separate IP addresses with commas'
    ],
    [
        'label' => 'GA Opt-in disclaimer Settings',
        'name' => 'gaOptInDisclaimerSettings',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => 'Use GA opt-in disclaimer',
        'name' => 'useGADisclaimer',
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => 1
    ],
    [
        'label' => 'Expiry Days',
        'name' => 'expiryDays',
        'type' => 'number',
        'min' => 1,
        'step' => 1,
        'default_value' => 30,
    ],
    [
        'label' => 'Layout',
        'name' => 'layout',
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'wrapper' => [
            'width' => 50
        ],
        'default_value' => 'layoutFloating',
        'choices' => [
            'layoutFloating' => 'Floating',
            'layoutBottom' => 'Bottom'
        ],
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'useGADisclaimer',
                    'operator' => '==',
                    'value' => '1'
                ]
            ]
        ],
    ],
    array_merge(Api::loadFields('FieldVariables', 'theme'), array(
        'wrapper' => [
            'width' => 50
        ],
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'useGADisclaimer',
                    'operator' => '==',
                    'value' => '1'
                ]
            ]
        ],
    ))
]);

Options::addTranslatable('GoogleAnalyticsOptIn', [
    [
        'label' => 'Content',
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'default_value' => '<h4>This website uses cookies</h4><p>We inform you that this site uses own, technical and third parties cookies to make sure our web page is user-friendly and to guarantee a high functionality of the webpage. By continuing to browse this website, you declare to accept the use of cookies.</p>',
        'media_upload' => 0,
        'delay' => 1,
        'required' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Accept Button Label',
        'name' => 'acceptButtonLabel',
        'type' => 'text',
        'default_value' => 'Accept',
        'required' => 1,
    ],
    [
        'label' => 'Decline Button Label',
        'name' => 'declineButtonLabel',
        'type' => 'text',
        'default_value' => 'Decline',
        'required' => 1,
    ],
]);
