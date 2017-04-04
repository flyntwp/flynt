<?php

namespace Flynt\Components\BlockNotFound;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockNotFound');
});
