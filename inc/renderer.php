<?php

use ACFComposer\ACFComposer;
use Flynt\Components;
use Timber\Timber;
use Timber\Twig;

use function Flynt\ComponentLogServer\consoleDebug;

function my_admin_menu() {
    add_menu_page(
        __( 'Sample page', 'my-textdomain' ),
        __( 'Sample menu', 'my-textdomain' ),
        'manage_options',
        'sample-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        3
    );
}
add_action( 'admin_menu', 'my_admin_menu' );

// function my_admin_page_contents() {
//     acf_enqueue_scripts();
//     ACFComposer::registerFieldGroup([
//         'name' => 'tmp',
//         'title' => '',
//         'fields' => Components\BlockImageText\getACFLayout()['sub_fields'],
//         'location' => []
//     ]);
//     acf_form([
//         'id' => 'flynt-renderer',
//         'field_groups' => [
//             'group_tmp'
//         ],
//     ]);
// }

function registerField() {
    ACFComposer::registerFieldGroup([
        'name' => 'tmp',
        'title' => '',
        'fields' => [
            [
                'label' => '',
                'name' => 'acc',
                'type' => 'accordion',
                'open' => 0,
                'multi_expand' => 0,
                'endpoint' => 0
            ],
            [
                'label' => 'Something',
                'name' => 'something',
                'type' => 'group',
                'sub_fields' => Components\BlockImageText\getACFLayout()['sub_fields'],
            ],
        ],
        'location' => []
    ]);
}

function getFieldInputName($field) {
    if (!empty($field['parent'])) {
        $parent = acf_get_field($field['parent']);
        if (!empty($parent)) {
            return getFieldInputName($parent) . '[' . $field['key'] . ']';
        }
    }
    return 'acf[' . $field['key'] . ']';
}

function my_admin_page_contents() {
    registerField();
    if (isset($_GET['customData'])) {
        $customData = json_decode(stripslashes_deep($_GET['customData']), true);
        // var_dump($customData);
        add_filter('acf/load_value', function ($value, $postId, $field) use ($customData) {
            $inputName = getFieldInputName($field);
            $val = $customData[$inputName] ?? null;

            return $val;
        }, 1, 3);
        // add_filter('acf/prepare_field', function ($field) use ($customData) {
        //     var_dump($field);die();
        //     $inputName = getFieldInputName($field);
        //     $value = $customData[$inputName];
        //     if ($value) {
        //         // var_dump($inputName, $value);
        //         $field['default_value'] = $value;
        //     }
        //     return $field;
        // });
    }
    // acf_enqueue_scripts();

    // echo '<form id="flynt-renderer">';
    // render_field(get_field_object('field_tmp_something'));
    // echo '</form>';
    acf_form_head();
    acf_form([
        'id' => 'flynt-renderer',
        'field_groups' => [
            'group_tmp'
        ],
        'html_before_fields' => '<input type="hidden" name="action" value="renderAcfComponent" />',
    ]);
    // echo '<iframe width="800" height="800" id="rendererIframe" src="/renderer"></iframe>';
    echo '<label for="iframe-scale">Scale</label>';
    echo '<input type="range" id="iframe-scale" min=0 max=1 step="0.01" value="0.5" />';
    echo '<div id="postmate"></div>';
}

function getFieldValues($keysAndValues) {
    $values = [];
    foreach($keysAndValues as $key => $value) {
        $field = acf_get_field($key);
        if ($field['sub_fields']) {
            $values[$field['name']] = getFieldValues($value);
        } else {
            $values[$field['name']] = acf_format_value($value, 0, $field);
        }
    }
    return $values;
}

add_filter('acf/pre_submit_form', function ($form) {
    registerField();
    $values = [];
    // var_dump($_POST, $GLOBALS['acf_form']);
    // foreach ( $_POST['acf'] as $key => $value ) {

	// 	// Get field.
	// 	$field = acf_get_field( $key );
    //     // var_dump($field['name']);
	// 	// Update value.
	// 	if ( $field ) {
    //         $values[$field['name']] = getFieldValues($key, $value);
    //         // if ($field['sub_fields'] ) {
    //         //     $values[ $field['name'] ] = [];
    //         //     foreach($value as $fieldKey => $fieldValue) {
    //         //         $fieldField = acf_get_field( $fieldKey );
    //         //         // $values[ $field['name'] ][$fieldField['name']] = acf_format_value(apply_filters( 'acf/update_value', $fieldValue, 0, $field, $fieldValue ), 0, $field);
    //         //         var_dump($fieldValue);
    //         //         $values[ $field['name'] ][$fieldField['name']] = acf_format_value($fieldValue, 0, $fieldField);
    //         //     }
    //         // } else {
    //         //     // $values[ $field['name'] ] = acf_format_value(apply_filters( 'acf/update_value', $value, 0, $field, $value ), 0, $field);
    //         //     var_dump($value);
    //         //     $values[ $field['name'] ] = acf_format_value($value, 0, $field);
    //         // }
	// 	}
	// }
    \Flynt\TimberLoader\addFilters();
    $values = getFieldValues($_POST['acf']);
    var_dump($values);
    echo Timber::compile_string("{{ renderComponent('BlockImageText', data) }}", [
        'data' => $values['something'],
    ]);
    // die();
});

function acfRenderComponent() {
    registerField();
    checkSubmit();
    $values = [];
    \Flynt\TimberLoader\addFilters();
    $values = getFieldValues($_POST['acf']);
    // var_dump($values);
    echo Timber::compile_string("{{ renderComponent('BlockImageText', data) }}", [
        'data' => $values['something'],
    ]);
    wp_die();
}

function checkSubmit() {
    // Verify nonce.
			if ( ! acf_verify_nonce( 'acf_form' ) ) {
				return false;
			}

			// Confirm form was submit.
			if ( ! isset( $_POST['_acf_form'] ) ) {
				return false;
			}

			// Load registered form using id.
			// $form = $this->get_form( acf_sanitize_request_args( $_POST['_acf_form'] ) );

			// // Fallback to encrypted JSON.
			// if ( ! $form ) {
			// 	$form = json_decode( acf_decrypt( sanitize_text_field( $_POST['_acf_form'] ) ), true );
			// 	if ( ! $form ) {
			// 		return false;
			// 	}
			// }

			// Run kses on all $_POST data.
			// if ( $form['kses'] && isset( $_POST['acf'] ) ) {
				$_POST['acf'] = wp_kses_post_deep( $_POST['acf'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- False positive.
			// }

			// Validate data and show errors.
			// Todo: Return WP_Error and show above form, keeping input values.
			acf_validate_save_post( true );
}

add_action('wp_ajax_renderAcfComponent', 'acfRenderComponent');
add_action('wp_ajax_nopriv_renderAcfComponent', 'acfRenderComponent');

// add_action('post_action_acf_renderer', function () {
//     var_dump(func_get_args());
//     die();
// }, 10, 10);
