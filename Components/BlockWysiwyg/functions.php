<?php

namespace Flynt\Components\BlockWysiwyg;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('BlockWysiwyg');
});
