<?php

namespace Flynt\Components\BlockCookieNotice;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_action('wp_footer', function () {
    $context = Timber::get_context();
    Timber::render_string('{{ renderComponent("BlockCookieNotice") }}', $context);
});

Options::addGlobal('BlockCookieNotice', [
    [
        'label' => __('Component Status', 'flynt'),
        'name' => 'cookieNoticeIsEnabled',
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => 1,
        'ui_on_text' => __('Activated', 'flynt'),
        'ui_off_text' => __('Deactivated', 'flynt'),
    ],
    [
        'label' => __('Layout', 'flynt'),
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
            'layoutFloating' => __('Floating', 'flynt'),
            'layoutBottom' => __('Bottom', 'flynt'),
        ]
    ],
    array_merge(FieldVariables\getTheme(), [
        'wrapper' => [
            'width' => 50
        ]
    ])
]);

Options::addTranslatable('BlockCookieNotice', [
    [
        'label' => __('General', 'flynt'),
        'name' => 'general',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'default_value' => '<h4>This website uses cookies</h4><p>We inform you that this site uses own, technical and third parties cookies to make sure our web page is user-friendly and to guarantee a high functionality of the webpage. By continuing to browse this website, you declare to accept the use of cookies.</p>',
        'media_upload' => 0,
        'delay' => 1,
        'required' => 1,
    ],
    [
        'label' => __('Close Button Label', 'flynt'),
        'name' => 'closeButtonLabel',
        'type' => 'text',
        'default_value' => 'Ok',
        'required' => 1,
    ],
]);
