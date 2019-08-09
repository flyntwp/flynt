<?php

namespace Flynt\Components\FormContactForm7;

use Flynt\Api;

add_filter('wpcf7_load_js', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

add_filter('Flynt/addComponentData?name=FormContactForm7', function ($data) {
    function_exists('wpcf7_enqueue_scripts') && enqueueWpcf7Scripts();
    function_exists('wpcf7_enqueue_styles') && wpcf7_enqueue_styles();

    return $data;
});

function enqueueWpcf7Scripts()
{
    $inFooter = true;

    if ('header' === wpcf7_load_js()) {
        $inFooter = false;
    }

    wp_enqueue_script(
        'contact-form-7',
        wpcf7_plugin_url('includes/js/scripts.js'),
        ['Flynt/assets'],
        WPCF7_VERSION,
        $inFooter
    );

    $wpcf7 = [
        'apiSettings' => [
            'root' => esc_url_raw(rest_url('contact-form-7/v1')),
            'namespace' => 'contact-form-7/v1',
        ],
    ];

    if (defined('WP_CACHE') and WP_CACHE) {
        $wpcf7['cached'] = 1;
    }

    if (wpcf7_support_html5_fallback()) {
        $wpcf7['jqueryUi'] = 1;
    }

    wp_localize_script('contact-form-7', 'wpcf7', $wpcf7);

    do_action('wpcf7_enqueue_scripts');
}

remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit', 10, 0);

add_action('wpcf7_init', function () {
    wpcf7_add_form_tag('submit', function ($tag) {
        $class = wpcf7_form_controls_class($tag->type, 'button');

        $atts = [];

        $atts['class'] = $tag->get_class_option($class);
        $atts['id'] = $tag->get_id_option();
        $atts['tabindex'] = $tag->get_option('tabindex', 'signed_int', true);

        $value = isset($tag->values[0]) ? $tag->values[0] : '';

        if (empty($value)) {
            $value = __('Send', 'contact-form-7');
        }

        $atts['type'] = 'submit';
        $atts['value'] = $value;

        $atts = wpcf7_format_atts($atts);

        $html = sprintf('<button %1$s>%2$s</button>', $atts, $value);
        return $html;
    });
}, 10, 0);

Api::registerFields('FormContactForm7', [
    'layout' => [
        'name' => 'FormContactForm7',
        'label' => 'Form: Contact Form 7',
        'sub_fields' => [
            [
                'label' => 'General',
                'name' => 'Tab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'name' => 'preContentHtml',
                'label' => 'Pre-Content',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'full',
                'wrapper' => [
                    'class' => 'autosize',
                ]
            ],
            [
                'label' => 'Contact Form 7 Form',
                'name' => 'formId',
                'type' => 'post_object',
                'post_type' => [
                    'wpcf7_contact_form'
                ],
                'allow_null' => 0,
                'multiple' => 0,
                'return_format' => 'id',
                'ui' => 1,
                'required' => 1,
                'instructions' => 'If there is no form available, please first create a suitable one in the <a href="' . admin_url('admin.php?page=wpcf7') . '" target="_blank">Contact Form 7 admin page</a>.',
            ],
            [
                'name' => 'contentFooterHtml',
                'label' => 'Content Footer',
                'type' => 'wysiwyg',
                'delay' => 1,
                'media_upload' => 0,
                'toolbar' => 'full',
                'required' => 0,
                'wrapper' => [
                    'class' => 'autosize',
                ]
            ],
            [
                'label' => 'Options',
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    Api::loadFields('FieldVariables', 'theme')
                ]
            ]
        ]
    ]
]);
