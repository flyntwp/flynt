<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;
use Timber\Menu;

add_action('init', function () {
    register_nav_menus([
        'navigation_footer' => __('Navigation Footer', 'flynt')
    ]);
});

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    $data['maxLevel'] = 0;
    $data['menu'] = new Menu('navigation_footer');

    return $data;
});

Options::addTranslatable('NavigationFooter', [
    [
        'label' => 'Copyright Text',
        'name' => 'copyrightText',
        'type' => 'text',
        'default_value' => 'Copyright © 2019. All rights reserved'
    ],
]);
