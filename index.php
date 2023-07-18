<?php

use Timber\Timber;

$context = Timber::context();

Timber::render('templates/index.twig', $context);
