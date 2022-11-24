<?php

use Timber\Timber;

$context = Timber::context();
$context['searchQuery'] = get_search_query();

Timber::render('templates/search.twig', $context);
