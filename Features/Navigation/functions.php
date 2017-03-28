<?php

namespace Flynt\Features\Navigation;

add_action('init', function () {
    register_nav_menus([
    'main_navigation' => __('Main Navigation', 'flynt-theme'),
    'footer_navigation' => __('Footer Navigation', 'flynt-theme')
    ]);
});
