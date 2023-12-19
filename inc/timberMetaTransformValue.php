<?php

/**
 * Transform ACF values to Timber/standard PHP objects.
 *
 */

namespace Flynt\TimberMetaTransformValue;

use Timber\Timber;

add_action('init', function () {
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
 * @param array $field
 * @return boolean
 */
function shouldTransformValue($value, $field)
{
    if (empty($value) || empty($field)) {
        return false;
    }

    if (!isset($field['return_format']) || !in_array($field['return_format'], ['array', 'object'])) {
        return false;
    }

    return true;
}

/**
 * Transform ACF file field
 *
 * @param string $value
 * @param int $id
 * @param array $field
 */
function transformFile($value, $id, $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_attachment($value);
}

function transformImage($value, $id, $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_image($value);
}

/**
 * Transform ACF gallery field
 *
 * @param array $value
 * @param int $id
 * @param array $field
 */
function transformGallery($value, $id, $field)
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
 * @param string $value
 * @param int $id
 * @param array $field
 */
function transformPostObject($value, $id, $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    if (!shouldTransformValue($value, $field)) {
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
 * @param string $value
 * @param int $id
 * @param array $field
 */
function transformRelationship($value, $id, $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    return Timber::get_posts($value);
}

/**
 * Transform ACF taxonomy field
 *
 * @param string $value
 * @param int $id
 * @param array $field
 */
function transformTaxonomy($value, $id, $field)
{
    if (empty($value) || !shouldTransformValue($value, $field)) {
        return $value;
    }

    if ($field['field_type'] === 'select' || $field['field_type'] === 'radio') {
        return Timber::get_term((int) $value);
    }

    return Timber::get_terms((array) $value);
}
