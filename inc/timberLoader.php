<?php

/**
 * - Enables rendering with Timber and Twig
 * - Convert ACF Images to Timber Images
 * - Convert ACF Field of type post_object to a Timber\Post
 * - Convert ACF Field of type taxonomy to a Timber\Term
 */

namespace Flynt\TimberLoader;

use Timber\Timber;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// To preserve conflicts add the filters only if the current request is not on an administrative interface page
// but also if the post action is “editpost“, which required to resolve an issue with twig and images.
if (!is_admin() || (isset($_POST['action']) && 'editpost' == $_POST['action'])) {
    $priority = 100;

    // Convert ACF Images to Timber Images
    add_filter('acf/format_value/type=image', NS . 'formatImage', $priority);

    // Convert ACF Gallery Images to Timber Images
    add_filter('acf/format_value/type=gallery', NS . 'formatGallery', $priority);

    // Convert ACF Field of type post_object to a Timber\Post
    add_filter('acf/format_value/type=post_object', NS . 'formatPostObject', $priority);

    // Convert ACF Field of type relationship to a Timber\Post
    add_filter('acf/format_value/type=relationship', NS . 'formatPostObject', $priority);

    // Convert ACF Field of type taxonomy to a Timber\Term
    add_filter('acf/format_value/type=taxonomy', NS . 'formatTaxonomy', $priority);
}

function formatImage($value)
{
    if (!empty($value)) {
        $value = Timber::get_Image($value);
    }
    return $value;
}

function formatGallery($value)
{
    if (!empty($value)) {
        $value = array_map(function ($image) {
            return Timber::get_Image($image);
        }, $value);
    }
    return $value;
}

function formatPostObject($value)
{
    if (is_array($value)) {
        $value = array_map(NS . 'convertToTimberPost', $value);
    } else {
        $value = convertToTimberPost($value);
    }
    return $value;
}

function convertToTimberPost($value)
{
    if (!empty($value) && is_object($value) && get_class($value) === 'WP_Post') {
        $value = Timber::get_Post($value);
    }
    return $value;
}

function formatTaxonomy($value)
{
    if (is_array($value)) {
        $value = array_map(NS . 'convertToTimberTaxonomy', $value);
    } else {
        $value = Timber::get_term($value);
    }
    return $value;
}

function convertToTimberTaxonomy($value)
{
    if (!empty($value) && is_object($value) && get_class($value) === 'WP_Term') {
        $value = Timber::get_term($value->term_id);
    }
    return $value;
}
