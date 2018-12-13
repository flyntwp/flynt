<?php

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::get_context();
$context['posts'] = new PostQuery();

Timber::render('twig/search.twig', $context);
