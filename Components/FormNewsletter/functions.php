<?php

namespace Flynt\Components\FormNewsletter;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('FormNewsletter', [
    'layout' => [
        'name' => 'formNewsletter',
        'label' => 'Form: Newsletter',
        'sub_fields' => [
            [
                'label' => 'Pre-built newsletter form',
                'name' => 'message',
                'type' => 'message',
                'message' => '<p>Form: Newsletter displays a predefined contact form with theme options and fixed content.</p><p>Make sure that all required options are set on the <a href="' . admin_url('admin.php?page=TranslatableOptions') . '" target="_blank">translatable options page</a>.</p>',
            ]
        ],
    ],
]);


add_action('Flynt/afterRegisterComponents', function () {
    Options::addTranslatable('FormNewsletter', [
        [
            'label' => '',
            'name' => 'form',
            'type' => 'group',
            'sub_fields' => Api::loadFields('FormContactForm7', 'layout.sub_fields'),
        ]
    ]);
});
