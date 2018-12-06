<?php

namespace Flynt\Components\LayoutMultiplePosts;

use Timber\Timber;
use Flynt\Features\Components\Component;
use WP_Query;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('LayoutMultiplePosts');
});

add_filter('Flynt/addComponentData?name=LayoutMultiplePosts', function ($data) {
    $query = !empty($data['query']) ? $data['query'] : false;
    $posts = Timber::get_posts($query);
    if (!empty($posts)) {
        $posts = array_map(function ($post) {
            $fields = get_fields($post->id);
            $post->fields = $fields === false ? [] : $fields;
            return $post;
        }, $posts);
    }
    $postsCount = is_search() ? getPostsCount($query) : null;

    $context = [
        'posts' => $posts,
        'pagination' => Timber::get_pagination(),
        'postsCount' => $postsCount,
    ];
    return array_merge(getPasswordContext(), $context, $data);
});

function getPasswordContext($postId = null)
{
    $passwordProtected = post_password_required($postId);
    return [
        'passwordProtected' => $passwordProtected,
        'passwordForm' => $passwordProtected ? get_the_password_form() : ''
    ];
}

function getPostsCount($query) {
    if ($query) {
        $wpQuery = new WP_Query($query);
    } else {
        global $wp_query;
        $wpQuery = $wp_query;
    }
    return $wpQuery->found_posts;
}
