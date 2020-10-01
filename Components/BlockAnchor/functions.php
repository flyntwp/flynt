<?php

namespace Flynt\Components\BlockAnchor;

use Flynt\Utils\Asset;
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
                    'label' => 'Enter unique name',
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => 'Use latin characters and add a unique name to create an anchor link.'
                ],
                [
                    'label' => 'Your unique anchor link: (select & copy)',
                    'name' => 'anchorLinkCopy',
                    'type' => 'message',
                    'message' => 'Copy',
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

    $copyIcon = [
        'copyIcon' => Asset::getContents('../assets/icons/copy.svg')
    ];

    $content = array_merge($copyIcon, $context);

    $html = Timber::compile(
        $componentPath . '/Partials/anchorLinkCopy.twig',
        $content
    );

    // Note: overrides whats in the original field config written
    $message = $html;

    $field['message'] = $message;
    return $field;
});
