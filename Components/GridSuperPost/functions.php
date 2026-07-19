<?php

namespace Flynt\Components\GridSuperPost;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

const DEFAULT_MAX_POSTS = 6;

add_filter('Flynt/addComponentData?name=GridSuperPost', function (array $data): array {
    $data['uuid'] ??= wp_generate_uuid4();

    $source = $data['contentSource'] ?? 'manual';
    $options = $data['options'] ?? [];
    $maxPosts = (int) ($options['maxPosts'] ?? DEFAULT_MAX_POSTS);
    $excerptWords = (int) ($options['excerptWords'] ?? 0);

    $data['cards'] = match ($source) {
        'postType' => getCardsFromPostType($data['postType'] ?? 'post', $maxPosts, $excerptWords),
        'category' => getCardsFromCategory($data['taxonomies'] ?? [], $maxPosts, $excerptWords),
        default => getCardsFromManual($data['manualCards'] ?? [], $excerptWords),
    };

    return $data;
});

function getCardsFromPostType(string $postType, int $maxPosts, int $excerptWords): array
{
    $posts = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => $postType,
        'posts_per_page' => $maxPosts,
        'ignore_sticky_posts' => 1,
    ]);

    return array_map(fn ($post) => buildCardFromPost($post, $excerptWords), $posts->to_array());
}

function getCardsFromCategory(array $taxonomies, int $maxPosts, int $excerptWords): array
{
    $posts = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => 'post',
        'cat' => implode(',', array_map(fn ($term) => $term->term_id, $taxonomies)),
        'posts_per_page' => $maxPosts,
        'ignore_sticky_posts' => 1,
    ]);

    return array_map(fn ($post) => buildCardFromPost($post, $excerptWords), $posts->to_array());
}

function buildCardFromPost($post, int $excerptWords): array
{
    $terms = $post->terms('category');
    $author = $post->author();

    return [
        'title' => $post->title(),
        'link' => $post->link(),
        'image' => normalizeImage($post->thumbnail(), $post->title()),
        'category' => $terms ? $terms[0]->name : null,
        'date' => $post->date('M j, Y'),
        'content' => $post->content(),
        'author' => $author ? $author->name() : null,
        'excerpt' => $excerptWords > 0 ? (string) $post->excerpt()->length($excerptWords)->read_more(false) : '',
        'hoverStyle' => null,
    ];
}

function getCardsFromManual(array $manualCards, int $excerptWords): array
{
    return array_map(function ($card) use ($excerptWords) {
        $excerpt = $card['excerpt'] ?? '';

        return [
            'title' => $card['title'] ?? '',
            'link' => $card['link'] ?? '',
            'image' => normalizeImage($card['featuredImage'] ?? null, $card['title'] ?? ''),
            'category' => $card['category'] ?: null,
            'date' => $card['date'] ?: null,
            'content' => null,
            'author' => $card['author'] ?: null,
            'excerpt' => $excerptWords > 0 && $excerpt ? wp_trim_words($excerpt, $excerptWords) : '',
            'hoverStyle' => $card['hoverStyle'] ?: null,
        ];
    }, $manualCards);
}

function normalizeImage($image, string $fallbackAlt): ?array
{
    if (!$image) {
        return null;
    }

    return [
        'src' => $image->src(),
        'alt' => $image->alt() ?: $fallbackAlt,
    ];
}

function getHoverStyleChoices(): array
{
    return [
        'none' => __('None', 'flynt'),
        'liftShadow' => __('Lift + Shadow', 'flynt'),
        'zoomOverlay' => __('Zoom + Overlay', 'flynt'),
        'gradientBorder' => __('Gradient Border Glow', 'flynt'),
        'tilt3d' => __('Tilt 3D', 'flynt'),
        'holo' => __('Holo Card', 'flynt'),
        'glassmorphism' => __('Glassmorphism + Shimmer Reveal', 'flynt'),
    ];
}

function getAvailablePostTypes(): array
{
    // Built with an explicit list rather than get_post_types(), since this
    // runs on after_setup_theme, before plugin-registered post types (e.g.
    // WooCommerce's "product", registered on init) exist yet.
    $postTypes = [
        'post' => __('Posts', 'flynt'),
        'page' => __('Pages', 'flynt'),
    ];

    if (class_exists('WooCommerce')) {
        $postTypes['product'] = __('Products', 'flynt');
    }

    return $postTypes;
}

function getACFLayout(): array
{
    $sourceIsField = fn (string $value) => [
        'conditional_logic' => [
            [
                [
                    'fieldPath' => 'contentSource',
                    'operator' => '==',
                    'value' => $value,
                ],
            ],
        ],
    ];

    return [
        'name' => 'gridSuperPost',
        'label' => __('Grid: Super Post', 'flynt'),
        'sub_fields' => [
            [
                'label' => __('Content', 'flynt'),
                'name' => 'contentTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Content Source', 'flynt'),
                'name' => 'contentSource',
                'type' => 'button_group',
                'choices' => [
                    'manual' => __('Manual', 'flynt'),
                    'postType' => __('Posts (CPTs)', 'flynt'),
                    'category' => __('Category', 'flynt'),
                ],
                'default_value' => 'manual',
            ],
            array_merge([
                'label' => __('Cards', 'flynt'),
                'name' => 'manualCards',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'block',
                'button_label' => __('Add Card', 'flynt'),
                'sub_fields' => [
                    [
                        'label' => __('Title', 'flynt'),
                        'name' => 'title',
                        'type' => 'text',
                        'required' => 1,
                    ],
                    [
                        'label' => __('Featured Image', 'flynt'),
                        'name' => 'featuredImage',
                        'type' => 'image',
                        'preview_size' => 'medium',
                        'mime_types' => 'jpg,jpeg,png,webp',
                    ],
                    [
                        'label' => __('Excerpt', 'flynt'),
                        'name' => 'excerpt',
                        'type' => 'textarea',
                        'rows' => 3,
                    ],
                    [
                        'label' => __('Link', 'flynt'),
                        'name' => 'link',
                        'type' => 'url',
                    ],
                    [
                        'label' => __('Category', 'flynt'),
                        'name' => 'category',
                        'type' => 'text',
                        'wrapper' => ['width' => 34],
                    ],
                    [
                        'label' => __('Date', 'flynt'),
                        'name' => 'date',
                        'type' => 'text',
                        'wrapper' => ['width' => 33],
                    ],
                    [
                        'label' => __('Author', 'flynt'),
                        'name' => 'author',
                        'type' => 'text',
                        'wrapper' => ['width' => 33],
                    ],
                    [
                        'label' => __('Hover Style', 'flynt'),
                        'instructions' => __('Overrides the grid-wide Hover Style option for this card only.', 'flynt'),
                        'name' => 'hoverStyle',
                        'type' => 'select',
                        'choices' => array_merge(['' => __('Use Default (Grid)', 'flynt')], getHoverStyleChoices()),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                    ],
                ],
            ], $sourceIsField('manual')),
            array_merge([
                'label' => __('Post Type', 'flynt'),
                'name' => 'postType',
                'type' => 'select',
                'choices' => getAvailablePostTypes(),
                'default_value' => 'post',
                'allow_null' => 0,
                'multiple' => 0,
                'ui' => 0,
            ], $sourceIsField('postType')),
            array_merge([
                'label' => __('Categories', 'flynt'),
                'instructions' => __('Select 1 or more categories or leave empty to show from all posts.', 'flynt'),
                'name' => 'taxonomies',
                'type' => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'multi_select',
                'allow_null' => 1,
                'multiple' => 1,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'object',
            ], $sourceIsField('category')),
            array_merge([
                'label' => __('Max Posts', 'flynt'),
                'name' => 'maxPosts',
                'type' => 'number',
                'default_value' => DEFAULT_MAX_POSTS,
                'min' => 1,
                'step' => 1,
            ], [
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'contentSource',
                            'operator' => '!=',
                            'value' => 'manual',
                        ],
                    ],
                ],
            ]),
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getTheme(),
                    [
                        'label' => __('Hover Style', 'flynt'),
                        'instructions' => __('Default hover style for all cards. Manual cards can override this individually.', 'flynt'),
                        'name' => 'hoverStyle',
                        'type' => 'select',
                        'choices' => getHoverStyleChoices(),
                        'default_value' => 'liftShadow',
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                    ],
                    [
                        'label' => __('Show Featured Image', 'flynt'),
                        'name' => 'showFeaturedImage',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Show Category', 'flynt'),
                        'name' => 'showCategory',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Show Title', 'flynt'),
                        'name' => 'showTitle',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Show Date', 'flynt'),
                        'name' => 'showDate',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Show Reading Time', 'flynt'),
                        'instructions' => __('Ignored for manually added cards.', 'flynt'),
                        'name' => 'showReadingTime',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Show Author', 'flynt'),
                        'name' => 'showAuthor',
                        'type' => 'true_false',
                        'default_value' => 0,
                        'ui' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                    [
                        'label' => __('Excerpt Words', 'flynt'),
                        'instructions' => __('0 hides the excerpt.', 'flynt'),
                        'name' => 'excerptWords',
                        'type' => 'number',
                        'default_value' => 0,
                        'min' => 0,
                        'step' => 1,
                        'wrapper' => ['width' => 25],
                    ],
                ],
            ],
        ],
    ];
}

Options::addTranslatable('GridSuperPost', [
    [
        'label' => __('Labels', 'flynt'),
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Reading Time - (20) min read', 'flynt'),
                'instructions' => __('%d is placeholder for number of minutes', 'flynt'),
                'name' => 'readingTime',
                'type' => 'text',
                'default_value' => __('%d min read', 'flynt'),
                'required' => 1,
            ],
        ],
    ],
]);
