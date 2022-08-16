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
                    'label' => __('Enter unique anchor name', 'flynt'),
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
                    'instructions' => __('Enter a unique name to create an anchor link.', 'flynt'),
                ],
                [
                    'label' => __('Anchor link', 'flynt'),
                    'name' => 'anchorLink',
                    'type' => 'message',
                    'new_lines' => '',
                    'esc_html' => 0,
                ],
            ],
        ]
    ];
}

add_filter('acf/load_field/name=anchorLink', function ($field) {
    global $post;
    $post = new Post($post);
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
        'copiedMessage' => __('Link copied ', 'flynt'),
        'description' => __('Copy the link and use it anywhere on the page to scroll to this position.', 'flynt'),
        'buttonText' =>  __('Copy link', 'flynt')
    ];
    $content = array_merge($content, $context);
    $message = Timber::compile(
        $componentPath . '/Partials/_anchorLink.twig',
        $content
    );
    $field['message'] = $message;

    $field['label'] =  sprintf(
        '<p class="anchorLink-url" data-href="%1$s">%2$s#</p>',
        $post->link,
        $post->link
    );
    return $field;
});
