<?php

/**
 * Renders representative markup on route /BaseStyle/ to do proper base styling.
 */

use Timber\Timber;

// hide admin bar
add_filter('show_admin_bar', '__return_false');
define( 'QM_DISABLED', true );
define('QM_HIDE_SELF', true);


$context = Timber::context();

Timber::render('templates/renderer.twig', $context);
