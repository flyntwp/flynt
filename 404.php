<?php

use Timber\Timber;

$context = Timber::context();

Timber::render('templates/404.twig', $context);
