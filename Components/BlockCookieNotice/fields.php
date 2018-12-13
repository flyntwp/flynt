<?php

use Flynt\Utils\Options;

Options::addTranslatable('BlockCookieNotice', [
    [
        'label' => 'Content',
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'tabs' => 'visual,text',
        'toolbar' => 'full',
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
