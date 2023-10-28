<?php

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
use Flynt\Components;
use Timber\Timber;

function my_admin_menu()
{
    add_menu_page(
        __('Flynt Studio', 'flynt'),
        __('Flynt Studio', 'flynt'),
        'manage_options',
        'sample-page',
        'my_admin_page_contents',
        'dashicons-schedule',
        3
    );
}

add_action('admin_menu', 'my_admin_menu');


function registerField($componentName)
{
    ACFComposer::registerFieldGroup([
        'name' => 'tmp',
        'title' => '',
        'menu_order' => 10,
        'fields' => [
            [
                'label' => '',
                'name' => "fcr_$componentName",
                'type' => 'group',

                'sub_fields' => "Flynt\\Components\\$componentName\\getACFLayout"()['sub_fields'],
            ],
        ],
        'location' => []
    ]);
}

function my_admin_page_contents()
{
    $componentManager = ComponentManager::getInstance();
    $componentsNames = array_keys($componentManager->getAll());
    $currentComponent = $_GET['component'] ?? null;
    ?>
    <div class="flyntStudio wrap">
    <header>
        <h1>Flynt Studio</h1>
        <div class="component-list-select">
            <button
                class="component-list-toggle button button-primary"
                aria-controls="component-list-wrapper"
                aria-expanded="false"
            >
                Select a component
            </button>
            <div id="component-list-wrapper" class="component-list-wrapper" aria-hidden="true">
                <div class="flyntComponentSearch">
                    <label for="component-search" class="hidden">Search Components</label>
                    <input id="component-search" class="flyntComponentSearch-field" type="text" placeholder="Search...">
                </div>
                <ul class="component-list" id="component-list">
                    <?php
                    foreach ($componentsNames as $componentName) {
                        if (function_exists("\\Flynt\\Components\\$componentName\\getACFLayout")) { ?>
                            <li><a href="#" class="component-list-item" data-component-name="<?= $componentName ?>"><?= $componentName ?></a></li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
    </header>

    <?php
    if ($currentComponent) { ?>
        <div class="flyntStudio-iframes"></div>
        <div class="iframe-actions">
            <fieldset class="screen-size-checkboxes">
                <legend class="hidden">Screens</legend>
                <div class="screen-size-checkbox">
                    <input class="screen-toggle" id="mobile" value="mobile" type="checkbox" checked>
                    <label class="button" for="mobile">Mobile</label>
                </div>
                <div class="screen-size-checkbox">
                    <input class="screen-toggle" id="tablet" value="tablet" type="checkbox" checked>
                    <label class="button" for="tablet">Tablet</label>
                </div>
                <div class="screen-size-checkbox">
                    <input class="screen-toggle" id="desktop" value="desktop" type="checkbox" checked>
                    <label class="button" for="desktop">Desktop</label>
                </div>
            </fieldset>
            <div class="scale-slider">
                <label for="iframe-scale">Scale</label>
                <input type="range" id="iframe-scale" min=0 max=1 step="0.01" value="0.5"/>
            </div>
        </div>
        <?php
        registerField($currentComponent);
        acf_form_head();
        acf_form([
            'id' => 'flynt-renderer',
            'post_id' => 'options',
            'field_groups' => [
                'group_tmp'
            ],
            'html_before_fields' => <<<EOL
                <input type="hidden" name="action" value="renderAcfComponent" />
                <input type="hidden" name="currentComponent" value="$currentComponent" />
            EOL,
        ]);
        // echo '<iframe width="800" height="800" id="rendererIframe" src="/renderer"></iframe>';
        ?>
        </div>
        <?php
    }
}

function acfRenderComponent()
{
    $componentName = $_POST['currentComponent'];
    registerField($componentName);
    checkSubmit();
    saveConfig();
    $values = [];
    \Flynt\TimberLoader\addFilters();
    $values = get_field("field_tmp_fcr_$componentName", 'options');
    echo Timber::compile_string("{{ renderComponent('$componentName', data) }}", [
        'data' => $values,
    ]);
    wp_die();
}

function saveConfig()
{
    $componentName = $_POST['currentComponent'];
    acf_update_values([
        "field_tmp_fcr_$componentName" => $_POST['acf']["field_tmp_fcr_$componentName"],
    ], 'options');
}

function checkSubmit()
{
    // Verify nonce.
    if (!acf_verify_nonce('acf_form')) {
        return false;
    }

    // Confirm form was submit.
    if (!isset($_POST['_acf_form'])) {
        return false;
    }

    // Load registered form using id.
    // $form = $this->get_form( acf_sanitize_request_args( $_POST['_acf_form'] ) );

    // // Fallback to encrypted JSON.
    // if ( ! $form ) {
    //  $form = json_decode( acf_decrypt( sanitize_text_field( $_POST['_acf_form'] ) ), true );
    //  if ( ! $form ) {
    //      return false;
    //  }
    // }

    // Run kses on all $_POST data.
    // if ( $form['kses'] && isset( $_POST['acf'] ) ) {
    $_POST['acf'] = wp_kses_post_deep($_POST['acf']); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- False positive.
    // }

    // Validate data and show errors.
    // Todo: Return WP_Error and show above form, keeping input values.
    acf_validate_save_post(true);
}

add_action('wp_ajax_renderAcfComponent', 'acfRenderComponent');
add_action('wp_ajax_nopriv_renderAcfComponent', 'acfRenderComponent');
