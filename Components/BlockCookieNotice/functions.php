<?php

namespace Flynt\Components\BlockCookieNotice;

use Flynt\Utils\Options;
use Flynt\Api;

Options::addGlobal('BlockCookieNotice', [
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
        ]
    ],
    array_merge(Api::loadFields('FieldVariables', 'theme'), array(
        'wrapper' => [
            'width' => 50
        ]
    ))
]);

Options::addTranslatable('BlockCookieNotice', [
    [
        'label' => 'Content',
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'default_value' => '<h4>This website uses cookies</h4><p>We inform you that this site uses own, technical and third parties cookies to make sure our web page is user-friendly and to guarantee a high functionality of the webpage. Would you like to accept these cookies?</p>',
        'media_upload' => 0,
        'delay' => 1,
        'required' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Decline Button Label',
        'name' => 'declineButtonLabel',
        'type' => 'text',
        'default_value' => 'Decline',
        'required' => 1,
    ],
    [
        'label' => 'Accept Button Label',
        'name' => 'acceptButtonLabel',
        'type' => 'text',
        'default_value' => 'Accept',
        'required' => 1,
    ],
]);
