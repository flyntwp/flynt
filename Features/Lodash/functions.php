<?php

namespace Flynt\Features\Lodash;

use Flynt\Utils\Asset;

add_action('wp_enqueue_scripts', function () {
    Asset::register([
        'type' => 'script',
        'name' => 'Flynt/Features/Lodash',
        'path' => 'Features/Lodash/script.js',
    ]);
});
