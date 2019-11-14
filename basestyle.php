<?php

/*
 * # Base Style Test Markup
 *
 * Renders representative markup on route /BaseStyle/ to do proper base styling.
 *
*/

use Timber\Timber;

$context = Timber::get_context();

Timber::render('templates/basestyle.twig', $context);
