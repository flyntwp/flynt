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
    $blogname = get_bloginfo('name');
    return $blogname;
});

/**
 * Tagline
 */
add_shortcode('tagline', function () {
    $tagline = get_bloginfo('description');
    return $tagline;
});

/**
 * Privacy Policy Link
 */
add_shortcode('privacyPolicyPageLink', function ($atts) {
    $data = shortcode_atts([
        'label' => __('Privacy Policy', 'flynt'),
        'target' => '_blank'
    ], $atts);

    $privacyPolicyPage = get_option('wp_page_for_privacy_policy');

    if ($privacyPolicyPage) {
        $privacyPolicyPageLink = esc_url(get_permalink($privacyPolicyPage));
    }

    if ($privacyPolicyPageLink) {
        $output = '<a href="' . $privacyPolicyPageLink . '" target="' . esc_attr($data['target']) . '" rel="noreferrer noopener">' . esc_attr($data['label']) . '</a>';
    } else {
        $output = esc_attr($data['label']);
    }

    return $output;
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
                'message' => '<code>[sitetitle]</code>',
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
                'message' => '<code>[tagline]</code>',
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
                'message' => '<code>[year]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ],
            [
                'label' => __('Privacy Policy Link', 'flynt'),
                'name' => 'messageShortcodePrivacyPolicyPageLink',
                'type' => 'message',
                'message' => '<code>[privacyPolicyPageLink label="' . __('Privacy Policy', 'flynt') . '" target="_blank"]</code>',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
                'wrapper' => [
                    'width' => 50
                ],
            ]
        ]
    ];
}
