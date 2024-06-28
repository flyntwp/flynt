<?php

namespace Flynt\Blocks;

use ACFComposer\ACFComposer;
use Flynt\ComponentManager;
use Flynt\Utils\Asset;
use Timber\Timber;
use WP_Block;

add_action('Flynt/afterRegisterComponents', function (): void {
    $components = ComponentManager::getInstance()->getAll();

    foreach ($components as $componentName => $componentPath) {
        $blockJsonPath = $componentPath . 'block.json';
        if (!file_exists($blockJsonPath)) {
            continue;
        }

        $block = json_decode(file_get_contents($blockJsonPath), true);
        $block['componentName'] = $componentName;

        $shouldUseRenderCallback = !isset($block['render']) && !isset($block['render_callback']);
        if ($shouldUseRenderCallback) {
            $block['render_callback'] = isset($block['render_callback']) ? $block['render_callback'] : 'Flynt\Blocks\renderBlock';

            $screenshotPath = $componentPath . 'screenshot.png';
            if (!isset($block['example']) && file_exists($screenshotPath)) {
                $screenshotUrl = get_template_directory_uri() . '/Components/' . $componentName . '/screenshot.png';
                $block['example']['screenshotUrl'] = $screenshotUrl;
            }
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

        acf_register_block($block);
    }
});

/**
 * Render callback for blocks
 *
 * @param array $attributes The block attributes.
 * @param string $content The inner blocks content.
 * @param bool $isPreview Whether the block is being rendered in the admin preview.
 * @param int $postId The post ID.
 * @param WP_Block|null $wpBlock
 */
function renderBlock(array $attributes, string $content = '', bool $isPreview = false, int $postId = 0, WP_Block|null $wpBlock = null): void
{
    if ($isPreview && isBlockEmpty($attributes) && hasScreenshotUrl($attributes)) {
        renderComponentScreenshot($attributes);
        return;
    }

    $fields = get_fields();
    if ($isPreview && !isSupportingJsx($attributes) && empty($fields) && hasScreenshotUrl($attributes)) {
        renderComponentScreenshot($attributes);
        return;
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

/**
 * Render a screenshot of the component
 *
 * @param array $attributes The block attributes.
 */
function renderComponentScreenshot(array $attributes): void
{
    $screenshotUrl = $attributes['example']['screenshotUrl'];
    if (filter_var($screenshotUrl, FILTER_VALIDATE_URL)) {
        echo '<img src="' . esc_url($screenshotUrl) . '" loading="lazy" />';
    }
}

/**
 * Check if the block supports JSX
 *
 * @param array $attributes The block attributes.
 * @return bool
 */
function isSupportingJsx($attributes): bool
{
    return isset($attributes['supports']['jsx']) && $attributes['supports']['jsx'] === true;
}

/**
 * Check if the block has a screenshot URL
 *
 * @param array $attributes The block attributes.
 * @return bool
 */
function hasScreenshotUrl($attributes): bool
{
    return is_array($attributes['example']) && !empty($attributes['example']['screenshotUrl']);
}

/**
 * Check if the block acf fields are empty
 *
 * @param array $attributes The block attributes.
 * @return bool
 */
function isBlockEmpty(array $attributes): bool
{
    $fields = acf_get_block_fields($attributes);
    $fieldIds = wp_list_pluck($fields, 'key');

    $blockData = array_chunk($attributes['data'], 2);
    foreach ($blockData as $field_data) {
        $currentValue = $field_data[0];
        $fieldKey = $field_data[1];

        if (empty($currentValue) || false !== strpos($currentValue, 'field_')) {
            continue;
        }

        $fieldKeyIndex = array_search($fieldKey, $fieldIds, true);
        if (empty($fields[$fieldKeyIndex]['default_value']) || $currentValue !== $fields[$fieldKeyIndex]['default_value']) {
            return false;
        }
    }

    return true;
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
