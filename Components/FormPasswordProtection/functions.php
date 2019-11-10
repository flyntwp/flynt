<?php

namespace Flynt\Components\FormPasswordProtection;

use Timber\Timber;
use Timber\Post;

add_filter('the_password_form', function ($output) {
    $context = Timber::get_context();
    $context['form'] = [
      'url' => site_url('/wp-login.php?action=postpass', 'login_post')
    ];

    return Timber::fetch('index.twig', $context);
});
