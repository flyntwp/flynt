<?php

namespace Flynt\Features\PasswordForm;

use Timber\Timber;
use Timber\Post;

add_filter('the_password_form', function ($output) {
  $context = Timber::get_context();
  $context['post'] = new Post();

  return Timber::fetch('index.twig', $context);
});

// @codingStandardsIgnoreLine
// function getPasswordForm ($postId = null) {
//   $context = Timber::get_context();
//   $post = new Post($postId);
//   $context['post'] = $post;
//
//   $output =  Timber::fetch('index.twig', $context);
//
//   return apply_filters('the_password_form', $output);
// }
