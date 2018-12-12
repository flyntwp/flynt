<?php
namespace Flynt\Components\BlockCookieNotice;

use Flynt\Features\Acf\OptionPages;
use Flynt\Features\Components\Component;

add_filter('Flynt/addComponentData?name=BlockCookieNotice', function ($data) {
    Component::enqueueAssets('BlockCookieNotice');

    return $data;
});
