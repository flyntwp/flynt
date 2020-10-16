<?php

namespace Flynt\FeaturedImageFallback;

use Flynt\Utils\Options;

Options::addGlobal('FeaturedImageFallback', [
    [
        'label' => __('Image', 'flynt'),
        'name' => 'image',
        'type' => 'image',
        'preview_size' => 'medium',
        'instructions' => __('Image-Format: JPG, PNG', 'flynt'),
        'required' => 1,
        'mime_types' => 'jpg,jpeg,png'
    ],
]);

add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {

    $fallbackFeaturedImageOptions = Options::getGlobal('FeaturedImageFallback');
    $fallbackFeaturedImage = $fallbackFeaturedImageOptions['image'];

    if ((int) $fallbackFeaturedImage->id !== (int) $post_thumbnail_id) {
        return $html;
    }

    if (isset($attr['class'])) {
        $attr['class'] .= ' fallback-featured-img';
    } else {
        $size_class = $size;
        if (is_array($size_class)) {
            $size_class = 'size-' . implode('x', $size_class);
        }
        // attachment-$size is a default class `wp_get_attachment_image` would otherwise add. It won't add it if there are classes already there.
        $attr = array('class' => "attachment-{$size_class} fallback-featured-img");
    }

    $html = wp_get_attachment_image($fallbackFeaturedImage->id, $size, false, $attr);
    return $html;
}, 5);

add_filter('get_post_metadata', function ($null, $object_id, $meta_key, $single) {
    // Only affect thumbnails on the frontend, do allow ajax calls.
    if ((is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX))) {
        return $null;
    }

    // Check only empty meta_key and '_thumbnail_id'.
    if (!empty($meta_key) && '_thumbnail_id' !== $meta_key) {
        return $null;
    }

    // Check if this post type supports featured images.
    if (!post_type_supports(get_post_type($object_id), 'thumbnail')) {
        return $null; // post type does not support featured images.
    }

    // Get current Cache.
    $meta_cache = wp_cache_get($object_id, 'post_meta');

    /**
     * Empty objects probably need to be initiated.
     *
     * @see get_metadata() in /wp-includes/meta.php
     */
    if (!$meta_cache) {
        $meta_cache = update_meta_cache('post', array($object_id));
        if (isset($meta_cache[$object_id])) {
            $meta_cache = $meta_cache[$object_id];
        } else {
            $meta_cache = array();
        }
    }

    // Is the _thumbnail_id present in cache?
    if (!empty($meta_cache['_thumbnail_id'][0])) {
        return $null; // it is present, don't check anymore.
    }

    // Get the Default Featured Image ID.
    $fallbackFeaturedImageOptions = Options::getGlobal('FeaturedImageFallback');
    $fallbackFeaturedImage = $fallbackFeaturedImageOptions['image'];

    $fallbackFeaturedImageId = $fallbackFeaturedImage->id;

    // Set the featuredImageFallback_thumbnail_id in cache.
    $meta_cache['_thumbnail_id'][0] = apply_filters('featuredImageFallback_thumbnail_id', $fallbackFeaturedImageId, $object_id);
    wp_cache_set($object_id, $meta_cache, 'post_meta');

    return $null;
}, 5, 4);
