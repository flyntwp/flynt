<?php

use Timber\Timber;
use Timber\Post;

$context = Timber::get_context();

Timber::render('twig/404.twig', $context);
