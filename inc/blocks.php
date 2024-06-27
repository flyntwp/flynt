<?php

namespace Flynt\Blocks;

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
use Flynt\Utils\Asset;
use Timber\Timber;
use WP_Block_Type_Registry;

add_action('Flynt/afterRegisterComponents', function () {
    $components = ComponentManager::getInstance()->getAll();

    foreach ($components as $componentName => $componentPath) {
        $blockJsonPath = $componentPath . 'block.json';
        if (!file_exists($blockJsonPath)) {
            continue;
        }

        $block = json_decode(file_get_contents($blockJsonPath), true);
        $block['componentName'] = $componentName;
        $block['render_callback'] = isset($block['render_callback']) ? $block['render_callback'] : 'Flynt\Blocks\renderBlock';


        $screenshotPath = $componentPath . 'screenshot.png';
        if (file_exists($screenshotPath)) {
            $screenshotUrl = get_template_directory_uri() . '/Components/' . $componentName . '/screenshot.png';
            $block['example'] = isset($block['example']) ? $block['example'] : ['screenshotUrl' => $screenshotUrl];
        }

        $getACFLayout = "Flynt\\Components\\$componentName\\getACFLayout";
        if (function_exists($getACFLayout)) {
            $acfLayout = $getACFLayout();

            ACFComposer::registerFieldGroup([
                'name' => $acfLayout['name'],
                'title' => $acfLayout['title'],
                'fields' => $acfLayout['sub_fields'],
                'location' => [
                    [
                        [
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/' . acf_slugify($block['name']),
                        ],
                    ],
                ],
            ]);
        }

        acf_register_block_type($block);
    }
});

function renderBlock($attributes, $content = '', $isPreview = false, $postId = 0, $wpBlock = null): void
{
    $fields = get_fields();
    if ($isPreview && empty($fields) && is_array($attributes['example']) && !empty($attributes['example']['screenshotUrl'])) {
        $screenshotUrl = $attributes['example']['screenshotUrl'];
        if (filter_var($screenshotUrl, FILTER_VALIDATE_URL)) {
            echo '<img src="' . esc_url($screenshotUrl) . '" loading="lazy" />';
            return;
        }
    }

    $componentName = $attributes['componentName'];
    $components = ComponentManager::getInstance()->getAll();
    $componentPath = $components[$componentName];

    $additionalData = [
        'isPreview' => $isPreview,
        'innerBlocksContent' => $content,
        'attributes' => $attributes,
    ];
    add_filter("Flynt/addComponentData?name={$componentName}", function ($data) use ($additionalData) {
        // Don't overwrite existing data
        return array_merge($additionalData ?: [], $data ?: []);
    }, 9);

    $fileToRender = $componentPath . 'index.twig';
    if (!file_exists($fileToRender)) {
        $message = sprintf(
            '%s %s',
            __('Template file not found:', 'flynt'),
            $fileToRender
        );
        echo '<div><code>' . esc_html($message) . '</code></div>';
    }

    $context = apply_filters("Flynt/addComponentData?name={$componentName}", $fields ?: [], $componentName);
    Timber::render($fileToRender, $context ?: []);
}

// Move to other file?
add_action('enqueue_block_editor_assets', function (): void {
    // Same as used for front-end, see assets.php
    wp_enqueue_script('Flynt/assets/main', Asset::requireUrl('assets/main.js'), [], null);
    wp_script_add_data('Flynt/assets/main', 'module', true);

    wp_localize_script('Flynt/assets/main', 'FlyntData', [
        'componentsWithScript' => ComponentManager::getInstance()->getComponentsWithScript(),
        'templateDirectoryUri' => get_template_directory_uri(),
    ]);
});
