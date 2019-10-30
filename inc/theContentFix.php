<?php

 use Timber\Timber;
 use Timber\Post;

add_filter('wp_insert_post_data', function ($data, $postArr) {
    if ($postArr['post_type'] === 'revision') {
        return $data;
    }
    if (empty($data['post_content'])) {
        $data['post_content'] = "[flyntTheContent id=\"{$postArr['ID']}\"]";
    }
    return $data;
}, 99, 2);

add_shortcode('flyntTheContent', function ($attrs) {
    $postId = $attrs['id'];
    $context = Timber::get_context();
    $context['post'] = $post = new Post($postId);
    return Timber::fetch('templates/theContentFix.twig', $context);
});
