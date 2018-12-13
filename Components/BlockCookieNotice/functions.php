<?php
namespace Flynt\Components\BlockCookieNotice;

use Flynt\Features\Acf\OptionPages;
use Flynt\Utils\Component;

add_filter('Flynt/addComponentData?name=BlockCookieNotice', function ($data) {
    Component::enqueueAssets('BlockCookieNotice');

    return $data;
});
