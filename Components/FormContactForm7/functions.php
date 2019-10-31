<?php

namespace Flynt\Components\FormContactForm7;

use Flynt\Api;
use Flynt\FieldVariables;

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
                    array_merge(FieldVariables::get('theme'), array(
                        'default_value' => 'themeDark'
                    )),
                    [
                        'label' => 'Show as Card',
                        'name' => 'card',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1
                    ]
                ]
            ],
            [
                'label' => 'Form Examples',
                'name' => 'templateTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'template',
                'type' => 'message',
                'message' => '
<pre>
<h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Form Newsletter</h4> '.htmlspecialchars('
<div class="form-flex">
  <div class="form-flex-col">
    [email* your-email placeholder "Enter your email"]
  </div>
  <div class="form-flex-col">
    [submit "Submit"]
  </div>
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Simple field</h4> '.htmlspecialchars('
<div class="form-group">
    <label for="yourCompany">Company</label>
    [text* your-company id:yourCompany placeholder "bleech"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Two columns row</h4> '.htmlspecialchars('
<div class="form-row-2">
    <div class="form-group">
        <label for="firstName">First Name</label>
        [text* first-name id:firstName placeholder "Dean"]
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        [text* last-name id:lastName placeholder "Winchester"]
    </div>
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Three columns row</h4> '.htmlspecialchars('
<div class="form-row-3">
    <div class="form-group">
        <label for="firstName">First Name</label>
        [text* first-name id:firstName placeholder "Dean"]
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        [text* last-name id:lastName placeholder "Winchester"]
    </div>
    <div class="form-group">
        <label for="yourEmail">Email</label>
        [email* your-email id:yourEmail placeholder "flynt@bleech.de"]
    </div>
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Two columns row (left column bigger than right)</h4> '.htmlspecialchars('
<div class="form-row-2-lg-left">
    <div class="form-group">
        <label for="yourAddress">Address</label>
        [text address id:yourAddress placeholder "Panoramastraße 1A"]
    </div>
    <div class="form-group">
        <label for="zipCode">Zip Code</label>
        [number zipcode id:zipCode placeholder "10178"]
    </div>
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Two columns row (right column bigger than left)</h4> '.htmlspecialchars('
<div class="form-row-2-lg-right">
    <div class="form-group">
        <label for="phoneCode">Code</label>
        [select menu-phone-code id:phoneCode "+345" "+44" "+7" "+49"]
    </div>
    <div class="form-group">
        <label for="mobilePhone">Phone Number</label>
        [tel mobile-phone id:mobilePhone placeholder "767-3842"]
    </div>
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Textarea</h4> '.htmlspecialchars('
<div class="form-group">
    <label for="yourMessage">Your Message</label>
    [textarea your-message id:yourMessage placeholder "Message here"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">URL field</h4> '.htmlspecialchars('
<div class="form-group">
    <label for="yourWebsite">Website</label>
    [url website id:yourWebsite placeholder "http://"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Date field</h4> '.htmlspecialchars('
<div class="form-group">
    <label for="yourDate">Date</label>
    [date date id:yourDate]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Checkbox</h4> '.htmlspecialchars('
<div class="form-group">
    [checkbox checkbox-555 use_label_element "some " "another" "else"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Radio</h4> '.htmlspecialchars('
<div class="form-group">
    [radio radio-647 default:1 use_label_element "some " "else" "another"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Acceptance</h4> '.htmlspecialchars('
<div class="form-group">
    [acceptance acceptance-782 use_label_element optional]
        By default, an acceptance checkbox is a different mechanism than
        general input validation, and it runs after all validation succeeds.
    [/acceptance]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Quiz field</h4> '.htmlspecialchars('
<div class="form-group label-wrap">
    [quiz quiz-413 "1+1=?|1" "1+2=?|3" "1+3=?|4"]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">File field</h4> '.htmlspecialchars('
<div class="form-group">
    [file file-838]
</div>
').' <h4 style="color: #ca4a1f;margin-bottom:0;font-size: 14px;">Submit button</h4> '.htmlspecialchars('
<div class="form-button">
    [submit "Send Message"]
</div>
').'
</pre>
                ',
                'new_lines' => 'wpautop',
                'esc_html' => 0
            ],
        ]
    ]
]);
