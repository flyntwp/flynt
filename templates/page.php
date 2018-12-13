<?php

use Timber\Timber;
use Timber\Post;

$context = Timber::get_context();
$post = new Post();
$context['post'] = $post;

Timber::render('twig/page.twig', $context);
