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
        'toolbar' => 'basic',
        'default_value' => '©&nbsp;[year] [sitetitle]'
    ],
    [
        'label' => __('Shortcode Examples', 'flynt'),
        'name' => 'templateTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => 0,
    ],
    [
        'label' => '',
        'name' => 'template',
        'type' => 'message',
        'message' => '
            <p>' . __('These shortcuts can generally be used anywhere and also within the content of the navigation footer. It’s best practice to switch to text mode before inserting a shortcode inside the visual editor.', 'flynt') . '</p>
            <p>' . sprintf(__('Notice: The Site Title (Website Name) can be changed at <a href="%s" target="_blank">Settings > General</a>.', 'flynt'), admin_url('options-general.php')) . '</p>
            <h3 style="color: #ca4a1f;margin-bottom:0;font-size: 16px;">' . __('Shortcode Examples', 'flynt') . '</h3>
            <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">' . sprintf(__('© %s Website Name', 'flynt'), date_i18n('Y')) . '</h4>
            <p>' . __('To display a Copyright symbol followed by the Current Year and the Site Title (Website Name), use the following line.', 'flynt') . '</p>
            <pre>©' . htmlspecialchars('&nbsp;') . '[year] [sitetitle]</pre>
            <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">' . sprintf(__('© %s Website Name — Subtitle', 'flynt'), date_i18n('Y')) . '</h4>
            <p>' . __('To display a Copyright symbol followed by the Current Year, the Site Title (Website Name) and the Tagline (Subtitle), use the following line.', 'flynt') . '</p>
            <pre>©' . htmlspecialchars('&nbsp;') . '[year] [sitetitle] ' . htmlspecialchars('&mdash;') . ' [tagline]</pre>
            <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">' . __('Current Year', 'flynt') . '</h4>
            <p>' . __('You can display the Current Year with the following shortcode, anywhere.', 'flynt') . '</p>
            <pre>[year]</pre>
            <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">' . __('Site Title (Website Name)', 'flynt') . '</h4>
            <p>' . __('You can display the Site Title (Website Name) with the following shortcode, anywhere.', 'flynt') . '</p>
            <pre>[sitetitle]</pre>
            <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">' . __('Tagline (Subtitle)', 'flynt') . '</h4>
            <p>' . __('You can display the Tagline (Subtitle) with the following shortcode, anywhere', 'flynt') . '</p>
            <pre>[tagline]</pre>',
        'new_lines' => 'wpautop',
        'esc_html' => 0
    ],
]);
