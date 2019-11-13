<?php

namespace Flynt\Components\BlockCookieNotice;

use Flynt\Utils\Options;
use Flynt\Api;
use Timber\Timber;

add_action('wp_footer', function () {
    $context = Timber::get_context();
    Timber::render_string('{{ renderComponent("BlockCookieNotice") }}', $context);
});

Options::addGlobal('BlockCookieNotice', [
    [
        'label' => 'Component Status',
        'name' => 'cookieNoticeIsEnabled',
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => 1,
        'ui_on_text' => 'Activated',
        'ui_off_text' => 'Deactivated',
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
        'default_value' => '<h4>This website uses cookies</h4><p>We inform you that this site uses own, technical and third parties cookies to make sure our web page is user-friendly and to guarantee a high functionality of the webpage. By continuing to browse this website, you declare to accept the use of cookies.</p>',
        'media_upload' => 0,
        'delay' => 1,
        'required' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Close Button Label',
        'name' => 'closeButtonLabel',
        'type' => 'text',
        'default_value' => 'Ok',
        'required' => 1,
    ],
]);
