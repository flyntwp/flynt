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
        'label' => __('General', 'flynt'),
        'name' => 'generalTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Content', 'flynt'),
        'name' => 'contentHtml',
        'type' => 'wysiwyg',
        'media_upload' => 0,
        'delay' => 1,
        'toolbar' => 'basic'
    ],
    [
        'label' => __('Options', 'flynt'),
        'name' => 'generalOptions',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0
    ],
    [
        'label' => __('Copyright Notice', 'flynt'),
        'name' => 'copyrightNotice',
        'instructions' => __('Display a Copyright Notice (consisting of the copyright sign [©] sign followed by the current year) in the footer.', 'flynt'),
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => 1,
    ],
    [
        'label' => __('Site Title', 'flynt'),
        'name' => 'siteName',
        'instructions' => __('Display the Site Title inside the footer. The Site Title can be changed at <a href="%s" target="_blank">Settings > General</a>', 'flynt', admin_url('options-general.php')),
        'type' => 'true_false',
        'default_value' => 1,
        'ui' => 1,
    ],
]);
