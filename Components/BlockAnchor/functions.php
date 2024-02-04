<?php

namespace Flynt\Components\BlockAnchor;

use Flynt\ComponentManager;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlockAnchor', function (array $data): array {
    if (isset($data['anchor'])) {
        $data['anchor'] = preg_replace('/[^A-Za-z0-9]/', '-', strtolower($data['anchor']));
    }

    return $data;
});

function getACFLayout(): array
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

add_filter('acf/load_field/name=anchorLink', function (array $field) {
    if (!is_admin()) {
        return $field;
    }

    $permalink = get_permalink();
    $field['label'] = sprintf(
        '<p class="anchorLink-url" data-href="%1$s">%2$s#</p>',
        $permalink,
        $permalink
    );

    $field['message'] = Timber::compile(
        ComponentManager::getInstance()->getComponentFilePath('BlockAnchor', 'Partials/_anchorLink.twig'),
        [
            'copiedMessage' => __('Link copied', 'flynt'),
            'description' => __('Copy the link and use it anywhere on the page to scroll to this position.', 'flynt'),
            'buttonText' =>  __('Copy link', 'flynt')
        ]
    );

    return $field;
});
