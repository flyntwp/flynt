<?php

use Timber\Timber;
use Timber\PostQuery;
use Flynt\Utils\Options;
use const Flynt\Archives\POST_TYPES;

$context = Timber::get_context();
$context['posts'] = new PostQuery();

if (isset($_GET['contentOnly'])) {
    $context['contentOnly'] = true;
}

if (is_home()) {
    $queriedPost = get_queried_object();
    $context['title'] = $queriedPost->post_title;
} else {
    $context['title'] =  get_the_archive_title();
    $context['description'] = get_the_archive_description();
}

Timber::render('twig/index.twig', $context);
