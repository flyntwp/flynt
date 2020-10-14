<?php

namespace Flynt\Components\BlockAnchor;

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Timber\Timber;
use Timber\Post;

add_filter('Flynt/addComponentData?name=BlockAnchor', function ($data) {
    if (isset($data['anchor'])) {
        $data['anchor'] = sanitize_title($data['anchor']);
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockAnchor',
        'label' => 'Block: Anchor',
        'sub_fields' => [
            [
                [
                    'label' => __('Enter unique name', 'flynt'),
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => __('Add a unique name to create an anchor link.<br>Allowed characters: [a-z].', 'flynt'),
                ],
                [
                    'label' => __('Instructions', 'flynt'),
                    'name' => 'anchorLinkCopy',
                    'type' => 'message',
                    'message' => __('', 'flynt'),
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
            ],
        ]
    ];
}

$fieldValidationMessage = __('Only [a-z] characters are allowed', 'flynt');

add_filter('acf/validate_value/name=anchor', function ($valid, $value, $field, $input_name) use ($fieldValidationMessage) {
    // Bail early if value is already invalid.
    if ($valid !== true) {
        return $valid;
    }

    if (preg_match('/[^a-z]/i', $value)) {
        return __($fieldValidationMessage, 'flynt');
    }

    return $valid;
}, 10, 4);

add_filter('acf/load_field/name=anchorLinkCopy', function ($field) {
    global $post;
    $post = new \Timber\Post($post);
    $message = $field['message'];
    $context = Timber::get_context();
    $context['post'] = new Post($post);

    if (isset($_GET['contentOnly'])) {
        $context['contentOnly'] = true;
    }

    $context['href'] = $post->link;

    $templateDir = get_template_directory();
    $componentPath = $templateDir . '/Components/BlockAnchor';

    $copyIcon = [
        'copyIcon' => Asset::getContents('../assets/icons/copy.svg')
    ];

    $translatableOptions = Options::getTranslatable('BlockAnchor');

    $content = array_merge($copyIcon, $translatableOptions, $context);

    $html = Timber::compile(
        $componentPath . '/Partials/anchorLinkCopy.twig',
        $content
    );

    // Note: overrides whats in the original field config written
    $message = $html;

    $field['message'] = $message;
    return $field;
});

Options::addTranslatable('BlockAnchor', [
    [
        'label' => 'Anchor Link Copy Instructions',
        'name' => 'anchorCopyInstructions',
        'type' => 'text',
        'default_value' => __('Copy the link below and use it anywhere on the page to scroll to this position.', 'flynt'),
    ],
    [
        'label' => 'Copied Message',
        'name' => 'copiedMessage',
        'type' => 'text',
        'default_value' => 'Copied!'
    ],
]);
