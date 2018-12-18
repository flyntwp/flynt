<?php

/*
 * # Base Style Test Markup
 *
 * Renders representative markup to do proper base styling.
 *
 * ## Installation
 *
 * 1. Enable `BaseStyle` feature in `inc/Init.php` by adding `Feature::register('BaseStyle', $basePath);`;
 *
 * This will add a route `/BaseStyle/` directing to this template.
 * The feature also ensures that the template is only accessible on non-production environments,
 * or for logged in users with edit rights at least and also disallows indexing for this page.
 *
 * ## Usage
 *
 * 1. Log into your WordPress Backend with an Administrator account.
 * 2. Navigate your browser to `/BaseStyle/`.
 *
*/

use Timber\Timber;

$context = Timber::get_context();

Timber::render('twig/basestyle.twig', $context);
