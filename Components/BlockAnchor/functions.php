<?php

namespace Flynt\Components\BlockAnchor;

use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockAnchor', function ($data) {
    if (isset($data['anchor'])) {
        $data['anchor'] = preg_replace('/[^A-Za-z0-9]/', '-', strtolower($data['anchor']));
    }

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockAnchor',
        'label' => __('Block: Anchor', 'flynt'),
        'sub_fields' => [
            [
                [
                    'label' => __('Enter unique anchor name', 'flynt'),
                    'instructions' => __('Enter a unique name to create an anchor link.', 'flynt'),
                    'name' => 'anchor',
                    'type' => 'text',
                    'required' => 1,
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
    $post = Timber::get_Post($post);
    $context = Timber::context();
    $context['post'] = $post;
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
