<?php

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
use Timber\Timber;

function my_admin_menu() {
    add_menu_page(
        __( 'Flynt Studio', 'flynt' ),
        __( 'Flynt Studio', 'flynt' ),
        'manage_options',
        'sample-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        3
    );
}
add_action( 'admin_menu', 'my_admin_menu' );


function registerField($componentName) {
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
                'label' => 'Current Component',
                'name' => 'component',
                'type' => 'group',
                'sub_fields' => "Flynt\\Components\\$componentName\\getACFLayout"()['sub_fields'],
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
    return $field['key'];
}

function my_admin_page_contents() {
    $componentManager = ComponentManager::getInstance();
    $componentsNames = array_keys($componentManager->getAll());
    echo '<ul id="component-list">';
    foreach ($componentsNames as $componentName) {
        if (function_exists("\\Flynt\\Components\\$componentName\\getACFLayout"))
        echo '<li><a href="#" data-component-name="' . $componentName . '">' . $componentName . '</a></li>';
    }
    echo '</ul>';
    $currentComponent = $_GET['component'] ?? null;
    if ($currentComponent) {
        registerField($currentComponent);
        prepareLoadValues();
        acf_form_head();
        acf_form([
            'id' => 'flynt-renderer',
            'field_groups' => [
                'group_tmp'
            ],
            'html_before_fields' => <<<EOL
                <input type="hidden" name="action" value="renderAcfComponent" />
                <input type="hidden" name="currentComponent" value="$currentComponent" />
            EOL,
        ]);
        // echo '<iframe width="800" height="800" id="rendererIframe" src="/renderer"></iframe>';
        echo '<label for="iframe-scale">Scale</label>';
        echo '<input type="range" id="iframe-scale" min=0 max=1 step="0.01" value="0.5" />';
        echo '<div id="postmate"></div>';
    }
}

function prepareLoadValues() {
    $config = get_option('flynt_render_config', []);
    $componentConfig = $config[$_GET['component']] ?? null;
    if (isset($componentConfig)) {
        add_filter('acf/load_value', function ($value, $postId, $field) use ($componentConfig) {
            $val = getValueForField($field, $componentConfig);
            return $val;
        }, 1, 3);
    }
}

function getParents($field, &$parents = []) {
    if ($field['parent']) {
        $parent = acf_get_field($field['parent']);
        array_unshift($parents, $parent);
        if ($parent['key'] ?? null) {
            return getParents($parent, $parents);
        }
    }
    return $parents;
}

function getValueForField($field, $values) {
    $parents = getParents($field);
    foreach ($parents as $parent) {
        if ($parent['key'] ?? null) {
            $values = $values[$parent['key']] ?? null;
        }
    }
    return $values[$field['key']] ?? null;
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

function acfRenderComponent() {
    $componentName = $_POST['currentComponent'];
    registerField($componentName);
    checkSubmit();
    saveConfig();
    $values = [];
    \Flynt\TimberLoader\addFilters();
    $values = getFieldValues($_POST['acf']);
    echo Timber::compile_string("{{ renderComponent('$componentName', data) }}", [
        'data' => $values['component'],
    ]);
    wp_die();
}

function saveConfig() {
    $config = get_option('flynt_render_config', []);
    $componentName = $_POST['currentComponent'];
    $config[$componentName] = $_REQUEST['acf'];
    update_option('flynt_render_config', $config);
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
