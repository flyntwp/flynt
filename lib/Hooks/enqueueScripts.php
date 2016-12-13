<?php

namespace Flynt\Hooks;

use Flynt\Helpers\Utils;

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'Modules/scripts',
    Utils::requireAssetUrl('Modules/script.js'),
    ['jquery'],
    null,
    true
  );
});
