<?php

use Timber\Timber;

$context = Timber::get_context();

Timber::render('templates/404.twig', $context);
