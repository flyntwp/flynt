<?php
namespace Flynt\Components\ListPostCards;

use Flynt\Utils\Component;
use Timber\Timber;
use Timber\Post;

add_filter('Flynt/addComponentData?name=ListPostCards', function ($data) {
    Component::enqueueAssets('ListPostCards');

    $posts = Timber::get_posts([
        'post_type'         => 'post',
        'posts_per_page'    => 4,
        'category'          => $data['category']
    ]);

    $data['posts'] = $posts;

    return $data;
});
