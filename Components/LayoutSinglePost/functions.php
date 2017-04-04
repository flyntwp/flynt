<?php

namespace Flynt\Components\LayoutSinglePost;

use Timber\Timber;
use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('LayoutSinglePost');
});

add_filter('Flynt/addComponentData?name=LayoutSinglePost', function ($data) {
    $query = !empty($data['query']) ? $data['query'] : false;
    $post = Timber::get_post($query);
    if (!empty($post)) {
        $fields = get_fields($post->id);
        $post->fields = $fields === false ? [] : $fields;
    }
    $context = [
        'post' => $post
    ];
    if (is_object($post)) {
        return array_merge(getPasswordContext($post->ID), $context, $data);
    } else {
        return array_merge($context, $data);
    }
});

function getPasswordContext($postId)
{
    $passwordProtected = post_password_required($postId);
    return [
        'passwordProtected' => $passwordProtected,
        'passwordForm' => $passwordProtected ? get_the_password_form() : ''
    ];
}
