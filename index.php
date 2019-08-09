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

Timber::render('templates/index.twig', $context);
