<?php

namespace Flynt\Components\BlockShare;

use Flynt\Utils\Asset;
use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockShare', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockShare');
    });

    if (!empty($data['share'])) {
        $data['share'] = array_map(function ($item) {
            $item['icon'] = Asset::getContents("Components/BlockShare/Assets/{$item['platform']}.svg");
            return $item;
        }, $data['share']);
    }

    return $data;
});
