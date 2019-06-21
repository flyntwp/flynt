<?php

use Timber\Timber;
use Timber\PostQuery;
use Flynt\Utils\Options;
use const Flynt\Archives\POST_TYPES;

$context = Timber::get_context();
$context['posts'] = new PostQuery();

if (is_archive() || is_home()) {
    global $wp_query;
    $postType = ($wp_query->query_vars['post_type'] ?? 'post') ?: 'post';
    $context['data'] = Options::get('translatableOptions', 'feature', POST_TYPES[$postType] . 'Archive');
    $template = 'twig/archive.twig';
} else {
    $template = 'twig/index.twig';
}

Timber::render($template, $context);
