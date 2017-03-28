<?php
namespace Flynt\Components\ImageHero;

use Flynt\Features\Components\Component;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('ImageHero');
});
