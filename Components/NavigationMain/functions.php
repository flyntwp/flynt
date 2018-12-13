<?php

namespace Flynt\Components\NavigationMain;

use Flynt\Utils\Component;
use Flynt\Utils\Asset;
use Timber\Menu;
use Flynt\Features\Acf\OptionPages;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationMain');
});

add_filter('Flynt/addComponentData?name=NavigationMain', function ($data) {
    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : 'navigation_main';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;

    if (!empty($data['menu'])) {
        $data['menu']->items = array_map(function ($item) {
            $item->btnClasses = array_filter($item->classes, function ($class) {
                return stripos(trim($class), 'btn') === 0;
            });
            $item->classes = array_diff($item->classes, $item->btnClasses);
            return $item;
        }, $data['menu']->items);
    }

    $data['siteTitle'] = get_bloginfo('name');
    $data['logo'] = Asset::requireUrl('Components/NavigationMain/Assets/logo.svg');
    return $data;
});

add_action('init', function () {
    register_nav_menus([
        'navigation_main' => __('Navigation Main', 'flynt-starter-theme')
    ]);
});
