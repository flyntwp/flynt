<?php

/**
 * - Enables rendering with Timber and Twig.
 * - Converts ACF Images to Timber Images if ACF is enabled.
 * - Convert ACF Field of type post_object to a Timber\Post and add all ACF Fields of that Post
 */

namespace Flynt\TimberLoader;

use Flynt\Utils\TwigExtensionFlynt;
use Flynt;
use Timber\Image;
use Timber\Post;
use Timber\Timber;
use Twig\TwigFunction;

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');

// Convert ACF Images to Timber Images
add_filter('acf/format_value/type=image', NS . 'formatImage', 100);

// Convert ACF Gallery Images to Timber Images
add_filter('acf/format_value/type=gallery', NS . 'formatGallery', 100);

// Convert ACF Field of type post_object to a Timber\Post and add all ACF Fields of that Post
add_filter('acf/format_value/type=post_object', NS . 'formatPostObject', 100);

// Convert ACF Field of type relationship to a Timber\Post and add all ACF Fields of that Post
add_filter('acf/format_value/type=relationship', NS . 'formatPostObject', 100);
add_filter('get_twig', function ($twig) {
    $twig->addExtension(new TwigExtensionFlynt());
    return $twig;
});

function formatImage($value)
{
    if (!empty($value)) {
        $value = new Image($value);
    }
    return $value;
}

function formatGallery($value)
{
    if (!empty($value)) {
        $value = array_map(function ($image) {
            return new Image($image);
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
        $value = new Post($value);
    }
    return $value;
}

add_action('timber/twig/filters', function ($twig) {
    $twig->addFunction(new TwigFunction('placeholderImage', function ($width, $height, $color = null) {
        $width = round($width);
        $height = round($height);
        $colorRect = $color ? "<rect width='{$width}' height='{$height}' style='fill:$color' />" : '';
        $svg = "<svg width='{$width}' height='{$height}' xmlns='http://www.w3.org/2000/svg'>{$colorRect}</svg>";
        return "data:image/svg+xml;base64," . base64_encode($svg);
    }));

    return $twig;
});
