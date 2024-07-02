<?php

/**
 * Transform ACF values to Timber/standard PHP objects.
 *
 */

namespace Flynt\TimberMetaTransformValues;

use Timber\Timber;

add_action('init', function (): void {
    $priority = 100;
    add_filter('acf/format_value/type=file', __NAMESPACE__ . '\transformFile', $priority, 3);
    add_filter('acf/format_value/type=image', __NAMESPACE__ . '\transformImage', $priority, 3);
    add_filter('acf/format_value/type=gallery', __NAMESPACE__ . '\transformGallery', $priority, 3);
    add_filter('acf/format_value/type=post_object', __NAMESPACE__ . '\transformPostObject', $priority, 3);
    add_filter('acf/format_value/type=relationship', __NAMESPACE__ . '\transformRelationship', $priority, 3);
    add_filter('acf/format_value/type=taxonomy', __NAMESPACE__ . '\transformTaxonomy', $priority, 3);
});

/**
 * Check if value should be transformed to Timber/standard PHP objects.
 *
 * @param mixed $value
 */
function shouldTransformValue($value, array $field): bool
{
    if (empty($value) || $field === []) {
        return false;
    }

    return isset($field['return_format']) && in_array($field['return_format'], ['array', 'object']);
}

/**
 * Transform ACF file field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformFile($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_attachment($value);
}

/**
 * Transform ACF image field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformImage($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_image($value);
}

/**
 * Transform ACF gallery field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformGallery($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return array_map(function ($image) {
        return Timber::get_Image($image);
    }, $value);
}

/**
 * Transform ACF post object field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformPostObject($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    if (!$field['multiple']) {
        return Timber::get_post($value);
    }

    return Timber::get_posts($value);
}

/**
 * Transform ACF relationship field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformRelationship($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_posts($value);
}

/**
 * Transform ACF taxonomy field
 *
 * @param mixed $value
 * @param int|string $id
 */
function transformTaxonomy($value, $id, array $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    if ($field['field_type'] === 'select' || $field['field_type'] === 'radio') {
        $termId = isset($value->term_id) ? $value->term_id : $value;
        return Timber::get_term((int) $termId);
    }

    return Timber::get_terms((array) $value);
}
