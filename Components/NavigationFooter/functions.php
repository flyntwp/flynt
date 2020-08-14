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

    if ($data['contentOptional'] == 'siteName') {
        $data['contentOptionalHtml'] = sprintf('%s', get_bloginfo(false, 'name'));
    } elseif ($data['contentOptional'] == 'copyrightNotice') {
        $data['contentOptionalHtml'] = sprintf('&copy;&nbsp;%d', date('Y'));
    } elseif ($data['contentOptional'] == 'copyrightNoticeAndSiteName') {
        $data['contentOptionalHtml'] = sprintf('&copy;&nbsp;%d %s', date('Y'), get_bloginfo(false, 'name'));
    }
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
        'label' => __('Optional content', 'flynt'),
        'name' => 'contentOptional',
        'instructions' => sprintf(__('Display optional content inside the footer. The Copyright Notice reflects the current year automatically. The Site Title can be changed at <a href="%s" target="_blank">Settings > General</a>.', 'flynt'), admin_url('options-general.php')),
        'type' => 'select',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'choices' => [
            '' => __('(none)', 'flynt'),
            'siteName' => sprintf('%s (%s)', get_bloginfo(false, 'name'), __('Site Title', 'flynt')),
            'copyrightNotice' => sprintf('&copy;&nbsp;%d (%s)', date('Y'), __('Copyright Notice', 'flynt')),
            'copyrightNoticeAndSiteName' => sprintf('&copy;&nbsp;%d %s (%s)', date('Y'), get_bloginfo(false, 'name'), __('Copyright Notice and Site Title', 'flynt')),
        ]
    ]
]);
