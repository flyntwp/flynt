<?php
// NOTE: Datamodelling: done
namespace Flynt\Components\NavigationFooter;

use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;
use Timber\Menu;

add_filter('Flynt/addComponentData?name=NavigationFooter', function ($data) {
    add_action('wp_enqueue_scripts', function () {
        Component::enqueueAssets('NavigationFooter');
    });

    // set max level of the menu
    $data['maxLevel'] = 0;
    $data['menuSlug'] = !empty($data['menuSlug']) ? $data['menuSlug'] : '';
    $data['menu'] = has_nav_menu($data['menuSlug']) ? new Menu($data['menuSlug']) : false;

    if (isset($data['theme'])) {
        $otherTheme = $data['theme']['key'] === 'dfa' ? 'dfp' : 'dfa';

        $data['icon'] = Asset::getContents('Components/NavigationFooter/Assets/ico-logo-m-' . $otherTheme . '.svg');
    }

    return $data;
});
