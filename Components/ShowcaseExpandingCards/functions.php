<?php

namespace Flynt\Components\ShowcaseExpandingCards;

use Flynt\FieldVariables;
use Timber\Timber;

const EXCERPT_WORDS = 18;

add_filter('Flynt/addComponentData?name=ShowcaseExpandingCards', function (array $data): array {
    if (($data['source'] ?? 'manual') === 'items' && !empty($data['items'])) {
        $data['cards'] = getCardsFromItems($data['items']);
        return $data;
    }

    if (empty($data['cards'])) {
        $data['cards'] = [
            [
                'image' => ['src' => 'https://picsum.photos/id/1018/900/1200', 'alt' => __('Wandering', 'flynt')],
                'title' => __('Wandering', 'flynt'),
                'subtitle' => __('A short line describing this card, shown once it is expanded open.', 'flynt'),
            ],
            [
                'image' => ['src' => 'https://picsum.photos/id/1015/900/1200', 'alt' => __('Stillness', 'flynt')],
                'title' => __('Stillness', 'flynt'),
                'subtitle' => __('A short line describing this card, shown once it is expanded open.', 'flynt'),
            ],
            [
                'image' => ['src' => 'https://picsum.photos/id/1016/900/1200', 'alt' => __('Growth', 'flynt')],
                'title' => __('Growth', 'flynt'),
                'subtitle' => __('A short line describing this card, shown once it is expanded open.', 'flynt'),
            ],
            [
                'image' => ['src' => 'https://picsum.photos/id/1019/900/1200', 'alt' => __('Clarity', 'flynt')],
                'title' => __('Clarity', 'flynt'),
                'subtitle' => __('A short line describing this card, shown once it is expanded open.', 'flynt'),
            ],
        ];
    }
    return $data;
});

function getCardsFromItems($items): array
{
    $itemArray = is_array($items) ? $items : $items->to_array();

    return array_map(fn ($post) => buildCard($post), $itemArray);
}

function buildCard($post): array
{
    $thumbnail = $post->thumbnail();

    return [
        'image' => $thumbnail ? [
            'src' => $thumbnail->src(),
            'alt' => $thumbnail->alt() ?: $post->title(),
        ] : getPlaceholderImage($post->title()),
        'title' => $post->title(),
        'subtitle' => (string) $post->excerpt()->length(EXCERPT_WORDS)->read_more(false),
        'link' => $post->link(),
    ];
}

function getPlaceholderImage(string $alt): array
{
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="900" height="1200" viewBox="0 0 900 1200">'
        . '<rect width="900" height="1200" fill="#64748b"/>'
        . '<g fill="none" stroke="#ffffff" stroke-width="14" stroke-linecap="round" stroke-linejoin="round" opacity="0.6">'
        . '<rect x="270" y="470" width="360" height="360" rx="24"/>'
        . '<circle cx="360" cy="560" r="30"/>'
        . '<path d="M270 740l105-105 75 75 135-135 135 135v90a30 30 0 0 1-30 30H300a30 30 0 0 1-30-30z"/>'
        . '</g></svg>';

    return [
        'src' => 'data:image/svg+xml;base64,' . base64_encode($svg),
        'alt' => $alt,
    ];
}

function getACFLayout(): array
{
    // Built with an explicit list rather than get_post_types(), since this
    // runs on after_setup_theme, before plugin-registered post types (e.g.
    // WooCommerce's "product", registered on init) exist yet.
    $itemPostTypes = ['post', 'page'];
    if (class_exists('WooCommerce')) {
        $itemPostTypes[] = 'product';
    }

    $sourceIsField = fn (string $value) => [
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'source',
                    'operator' => '==',
                    'value' => $value
                ]
            ]
        ],
    ];

    return [
        'name' => 'showcaseExpandingCards',
        'label' => __('Showcase: Expanding Cards', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => __('Subtitle', 'flynt'),
                'name' => 'subtitle',
                'type' => 'text',
            ],
            [
                'label' => __('Title', 'flynt'),
                'name' => 'title',
                'type' => 'text',
            ],
            [
                'label' => __('Source', 'flynt'),
                'name' => 'source',
                'type' => 'button_group',
                'choices' => [
                    'manual' => __('Manual', 'flynt'),
                    'items' => __('Selected Items', 'flynt'),
                ],
                'default_value' => 'manual',
            ],
            array_merge([
                'label' => __('Cards', 'flynt'),
                'name' => 'cards',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'row',
                'button_label' => __('Add Card', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Background Image', 'flynt'),
                        'name' => 'image',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,webp',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Excerpt', 'flynt'),
                        'name' => 'subtitle',
                        'type' => 'textarea',
                        'rows' => 2,
                        'instructions' => __('A short line, roughly 15-20 words.', 'flynt'),
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'url',
                        'instructions' => __('Only used when "Enable Links" is on in the Options tab.', 'flynt'),
                    ],
                ]
            ], $sourceIsField('manual')),
            array_merge([
                'label' => __('Items', 'flynt'),
                'instructions' => __('Pick which posts, pages, or other content to show as cards.', 'flynt'),
                'name' => 'items',
                'type' => 'post_object',
                'post_type' => $itemPostTypes,
                'multiple' => 1,
                'return_format' => 'object',
                'ui' => 1,
                'required' => 1,
            ], $sourceIsField('items')),
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getTheme(),
                    [
                        'label' => __('Enable Links', 'flynt'),
                        'instructions' => __('When a card is expanded, its title links to the linked post/page/item (or the manual link, in Manual mode).', 'flynt'),
                        'name' => 'enableLinks',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                    ],
                ]
            ]
        ]
    ];
}
