<?php

namespace Flynt\Utils;

use Timber\Post;

class TimberHelper
{
    public static function getTimberPostById($postId, $moreLinkText = null, $stripTeaser = false)
    {
        global $post;
        $post = get_post($postId);
        setup_postdata($post, $moreLinkText, $stripTeaser);
        $timberPost = new Post($post);
        wp_reset_postdata($post);
        return $timberPost;
    }

    public static function getExcerpt(
        $postId,
        $len = 50,
        $force = false,
        $readmore = "Read More",
        $strip = true,
        $end = "&hellip;"
    ) {
        global $post;
        $post = get_post($postId);
        setup_postdata($post, null, false);
        $timberPost = new Post($post);
        $excerpt = $timberPost->get_preview($len, $force, $readmore, $strip, $end);
        wp_reset_postdata($post);
        return $excerpt;
    }
}
