<?php

namespace Flynt\Components\FormPasswordProtection;

use Timber\Timber;

add_filter('the_password_form', function ($output) {
    $context = Timber::context();
    $context['form'] = [
      'url' => site_url('/wp-login.php?action=postpass', 'login_post')
    ];

    return Timber::compile('index.twig', $context);
});
