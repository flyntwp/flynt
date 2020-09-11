<?php

/**
 * Flynt Shortcodes
 */

namespace Flynt\Shortcodes;

/**
 * Current year
 */
add_shortcode('year', function () {
    $year = date_i18n('Y');
    return $year;
});

/**
 * Site Title
 */
add_shortcode('sitetitle', function () {
    $blogname = get_bloginfo(false, 'name');
    return $blogname;
});

/**
 * Tagline
 */
add_shortcode('tagline', function () {
    $tagline = get_bloginfo(false, 'description');
    return $tagline;
});

/**
 * Flynt Shortcode reference
 */
function getShortcodeReference()
{
    return [
        'label' => __('Shortcode Reference', 'flynt'),
        'name' => 'groupShortcodes',
        'instructions' => __('A Shortcode can generally be used inside text fields. It’s best practice to switch to text mode before inserting a shortcode inside the visual editor.', 'flynt'),
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => __('Site Title (Website Name)', 'flynt'),
                'name' => 'messageShortcodeSiteTitle',
                'type' => 'message',
                'message' => '<pre>[sitetitle]</pre>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Tagline (Subtitle)', 'flynt'),
                'name' => 'messageShortcodeTagline',
                'type' => 'message',
                'message' => '<pre>[tagline]</pre>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Current Year', 'flynt'),
                'name' => 'messageShortcodeCurrentYear',
                'type' => 'message',
                'message' => '<pre>[year]</pre>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
        ]
    ];
}
