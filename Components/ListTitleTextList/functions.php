<?php

namespace Flynt\Components\ListTitleTextList;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListTitleTextList', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('ListTitleTextList');
    });

    return $data;
});
