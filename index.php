<?php

use Timber\Timber;

$context = Timber::context();

if (isset($_GET['contentOnly'])) {
    $context['contentOnly'] = true;
}

Timber::render('templates/index.twig', $context);
