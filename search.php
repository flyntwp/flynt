<?php

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::get_context();
$context['posts'] = new PostQuery();
$context['searchQuery'] = get_search_query();

Timber::render('templates/search.twig', $context);
