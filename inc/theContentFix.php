<?php

namespace Flynt\TheContentFix;

use Timber\Timber;

add_filter('wp_insert_post_data', function (array $data, array $postArr) {
    if (
        in_array(
            $postArr['post_type'],
            [
                'revision',
                'nav_menu_item',
                'attachment',
                'customize_changeset',
                'custom_css',
                'acf-taxonomy',
                'acf-post-type',
                'acf-ui-options-page',
                'acf-field-group',
                'acf-field'
            ]
        )
    ) {
        return $data;
    }

    $isPostTypeSupportsGutenberg = post_type_supports($data['post_type'], 'editor');
    // Check if no content was saved before, or if there is a flyntTheContent shortcode but the id does not match the post id.
    if (
        !$isPostTypeSupportsGutenberg &&
        (!isset($data['post_content']) || $data['post_content'] === '' || !isPostIdInShortcode($data['post_content'], $postArr['ID']))
    ) {
        $data['post_content'] = "[flyntTheContent id=\"{$postArr['ID']}\"]";
    }

    return $data;
}, 99, 2);

add_shortcode('flyntTheContent', function (array $attrs) {
    if (is_admin()) {
        return;
    }

    $postId = $attrs['id'];
    // in case the post id was not set correctly and is 0
    if (!empty($postId)) {
        $context = Timber::context();
        $context['post'] = Timber::get_Post($postId);
        $context['post']->setup();
        return Timber::compile('templates/theContentFix.twig', $context);
    }
});

function isPostIdInShortcode($postContent, $postId): bool
{
    preg_match('/^\[flyntTheContent id=\\\"(\d*)\\\"\]$/', $postContent, $matches);

    if (!isset($matches) || count($matches) === 0) {
        return false;
    }

    return $matches[1] === $postId;
}
