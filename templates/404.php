<?php

use Timber\Timber;

$context = Timber::get_context();

Timber::render('twig/404.twig', $context);
