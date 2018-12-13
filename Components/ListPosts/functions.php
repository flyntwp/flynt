<?php

namespace Flynt\Components\ListPosts;

use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=ListPosts', function ($data) {
    Component::enqueueAssets('ListPosts');
    $data['isArchive'] = is_home() || is_archive();

    return $data;
});
