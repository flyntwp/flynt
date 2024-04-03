<?php

namespace Flynt\Components\FormPasswordProtection;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('the_password_form', function (): string {
    $context = Timber::context();
    $context['form'] = [
        'url' => site_url('/wp-login.php?action=postpass', 'login_post')
    ];
    $translatableOptions = Options::getTranslatable('FormPasswordProtection');
    if (!empty($translatableOptions)) {
        $context = array_replace_recursive($context, $translatableOptions);
    }

    return Timber::compile('index.twig', $context);
});

Options::addTranslatable('FormPasswordProtection', [
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Text', 'flynt'),
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'delay' => 0,
        'media_upload' => 0,
        'required' => 1,
        'default_value' => sprintf(
            '<h1 class="h3">%1$s</h1><p>%2$s %3$s</p>',
            __('Enter Password', 'flynt'),
            __('This content is password protected.', 'flynt'),
            __('To view it please enter your password below:', 'flynt')
        ),
    ],
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Input – Aria Label', 'flynt'),
                'name' => 'inputAriaLabel',
                'type' => 'text',
                'default_value' => __('Password', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Input – Placeholder', 'flynt'),
                'name' => 'inputPlaceholder',
                'type' => 'text',
                'default_value' => __('Enter password', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
            [
                'label' => __('Input – Submit', 'flynt'),
                'name' => 'buttonSubmit',
                'type' => 'text',
                'default_value' => __('Enter', 'flynt'),
                'required' => 1,
                'wrapper' => [
                    'width' => '50',
                ],
            ],
        ],
    ],
]);
