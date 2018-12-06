<?php

namespace Flynt\Components\HeroImageText;

use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=HeroImageText', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('HeroImageText');
    });

    // $data['image'] = new Image($data['image']);
    // if (empty($data['mobileImage'])) {
    //     $data['mobileImage'] = $data['image'];
    // } else {
    //     $data['mobileImage'] = new Image($data['mobileImage']);
    // }

    return $data;
});
