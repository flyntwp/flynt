<?php

namespace Flynt\Features\PasswordForm;

use Timber\Timber;
use Timber\Post;

add_filter('the_password_form', function ($output) {
    $context = Timber::get_context();
    $post = new Post();
    $context['form'] = [
      'url' => site_url('/wp-login.php?action=postpass', 'login_post'),
      'inputId' => empty($post->id) ? mt_rand() : $post->id
    ];

    return Timber::fetch('index.twig', $context);
});
