<?php

namespace Flynt\Features\Navigation;

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt-theme'),
        'navigation_footer' => __('Navigation Footer', 'flynt-theme')
    ]);
});
