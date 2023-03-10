<?php

/**
 * Renders representative markup on route /BaseStyle/ to do proper base styling.
 */

use Timber\Timber;

$context = Timber::context();

Timber::render('templates/basestyle.twig', $context);
