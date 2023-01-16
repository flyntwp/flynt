<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Utils\Options;

Options::addTranslatable('BlockNotFound', [
    [
        'label' => __('General', 'flynt'),
        'name' => 'general',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Content', 'flynt'),
        'instructions' => __('Content to be displayed on the 404 Not Found Page', 'flynt'),
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'media_upload' => 0,
        'default_value' => sprintf('<h1>%1$s</h1><p>%2$s</p>', __('Not Found', 'flynt'), __('The page you are looking for does not exist.', 'flynt')),
        'required' => 1,
        'delay' => 1,
    ],
    [
        'label' => __('Back to Homepage Label', 'flynt'),
        'instructions' => __('Leave empty to remove back to home link below the content area.', 'flynt'),
        'name' => 'backLinkLabel',
        'type' => 'text',
        'default_value' => __('Back to homepage', 'flynt')
    ]
]);
