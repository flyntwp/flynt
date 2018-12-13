<?php

use Timber\Timber;
use Timber\Post;

$context = Timber::get_context();
$context['post'] = new Post();

Timber::render('twig/page.twig', $context);
