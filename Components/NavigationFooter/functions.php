<?php

namespace Flynt\Components\NavigationFooter;

use Flynt\Utils\Options;
use Timber\Menu;
use Flynt\Shortcodes;

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
        'toolbar' => 'basic',
        'default_value' => '©&nbsp;[year] [sitetitle]'
    ],
    [
        'label' => __('Content Examples', 'flynt'),
        'name' => 'templateTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => __('Content Examples', 'flynt'),
        'name' => 'groupContentExamples',
        'instructions' => __('Want some content inspiration? Here they are!', 'flynt'),
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => sprintf(__('© %s Website Name', 'flynt'), date_i18n('Y')),
                'name' => 'messageShortcodeCopyrightYearWebsiteName',
                'type' => 'message',
                'message' => '<code>©' . htmlspecialchars('&nbsp;') . '[year] [sitetitle]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => sprintf(__('© %s Website Name — Subtitle', 'flynt'), date_i18n('Y')),
                'name' => 'messageShortcodeCopyrightYearWebsiteNameTagLine',
                'type' => 'message',
                'message' => '<code>©' . htmlspecialchars('&nbsp;') . '[year] [sitetitle] ' . htmlspecialchars('&mdash;') . ' [tagline]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ]
            ]
        ]
    ],
    Shortcodes\getShortcodeReference(),
]);
