<?php

namespace Flynt\Components\BlockShare;

use Flynt\Utils\Asset;
use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockShare', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('BlockShare');
    });

    $data['mail'] = Asset::getContents('Components/BlockShare/Assets/mail.svg');
    $data['facebook'] = Asset::getContents('Components/BlockShare/Assets/facebook.svg');
    $data['linkedin'] = Asset::getContents('Components/BlockShare/Assets/linkedin.svg');
    $data['twitter'] = Asset::getContents('Components/BlockShare/Assets/twitter.svg');
    $data['youtube'] = Asset::getContents('Components/BlockShare/Assets/youtube.svg');
    $data['xing'] = Asset::getContents('Components/BlockShare/Assets/xing.svg');
    $data['instagram'] = Asset::getContents('Components/BlockShare/Assets/instagram.svg');

    return $data;
});
