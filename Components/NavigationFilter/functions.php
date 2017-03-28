<?php
namespace Flynt\Components\NavigationFilter;

use Flynt\Features\Components\Component;

use Timber\Timber;
use Flynt\Utils\Log;

add_action('wp_enqueue_scripts', function () {
    Component::enqueueAssets('NavigationFilter');
});

add_filter('Flynt/addComponentData?name=NavigationFilter', function ($data) {
    $data['categories'] = Timber::get_terms('category');
    $data['categories'] = array_map(function ($category) {
        if (isset($_GET['category']) && $_GET['category'] === $category->slug) {
            $category->selectedAttribute = 'selected="selected"';
        } else {
            $category->selectedAttribute = '';
        }
        return $category;
    }, $data['categories']);

    $data['tags'] = Timber::get_terms('tags');
    $data['tags'] = array_map(function ($tag) {
        if (isset($_GET['filtertag']) && $_GET['filtertag'] === $tag->slug) {
            $tag->selectedAttribute = 'selected="selected"';
        } else {
            $tag->selectedAttribute = '';
        }
        return $tag;
    }, $data['tags']);

    return $data;
});
