<?php

namespace Flynt\Components\BlockAnchor;

use Timber\Timber;
use Timber\Post;

add_filter('Flynt/addComponentData?name=BlockAnchor', function ($data) {
    if (isset($data['anchor'])) {
        // convert to lowercase letters only
        $data['anchor'] = preg_replace('/[^a-zA-Z]/', '', strtolower($data['anchor']));
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
                    'instructions' => __('Enter a unique name to create an anchor link.<br>Copy the link below and use it anywhere on the page to scroll to this position.', 'flynt'),
                ],
                [
                    'label' => __('', 'flynt'),
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

    $content = [
        'copiedMessage' => __('Copied!', 'flynt'),
    ];

    $content = array_merge($content, $context);

    $html = Timber::compile(
        $componentPath . '/Partials/anchorLinkCopy.twig',
        $content
    );

    // Note: overrides whats in the original field config written
    $message = $html;

    $field['message'] = $message;
    return $field;
});
