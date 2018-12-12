<?php

namespace Flynt\Components\ListSocial;

use Flynt\Utils\Asset;
use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=ListSocial', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('ListSocial');
    });

    if (!empty($data['social'])) {
        $data['social'] = array_map(function ($item) {
            $item['icon'] = Asset::getContents("Components/ListSocial/Assets/{$item['platform']}.svg");
            return $item;
        }, $data['social']);
    }

    return $data;
});
