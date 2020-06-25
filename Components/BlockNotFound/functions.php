<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Utils\Options;

Options::addTranslatable('BlockNotFound', [
    [
        'label' => 'General',
        'name' => 'general',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => 'Content',
        'name' => 'contentHtml',
        'instructions' => 'Content to be displayed on the 404 Not Found Page',
        'type' => 'wysiwyg',
        'media_upload' => 0,
        'default_value' => '<h1>Not Found</h1><p>The page you are looking for does not exist.</p>',
        'required' => 1,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Back to Homepage Label',
        'name' => 'backLinkLabel',
        'instructions' => 'Leave empty to remove back to home link below the content area.',
        'type' => 'text',
        'default_value' => 'Back to homepage'
    ]
]);
