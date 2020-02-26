<?php

namespace Flynt\TheContentFix;

use Timber\Timber;
use Timber\Post;

function isShortcodeAndDoesNotMatchId($postContent, $postId)
{
    preg_match('/^\[flyntTheContent id=\\\"(\d*)\\\"\]$/', $postContent, $matches);
    if (!empty($matches) && $matches[1] != $postId) {
        return true;
    } else {
        return false;
    }
}

add_filter('wp_insert_post_data', function ($data, $postArr) {
    if (
        in_array(
            $postArr['post_type'],
            [
            'revision',
            'nav_menu_item',
            'attachment',
            'customize_changeset',
            'custom_css',
            ]
        )
    ) {
        return $data;
    }
    // check if no content was saved before, or if there is a flyntTheContent shortcode but the id does not match the post id
    if (empty($data['post_content']) || isShortcodeAndDoesNotMatchId($data['post_content'], $postArr['ID'])) {
        $data['post_content'] = "[flyntTheContent id=\"{$postArr['ID']}\"]";
    }
    return $data;
}, 99, 2);

add_shortcode('flyntTheContent', function ($attrs) {
    $postId = $attrs['id'];
    // in case the post id was not set correctly and is 0
    if (!empty($postId)) {
        $context = Timber::get_context();
        $context['post'] = new Post($postId);
        return Timber::fetch('templates/theContentFix.twig', $context);
    }
});
