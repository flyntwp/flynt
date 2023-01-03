<?php

namespace Flynt\Components\FormPasswordProtection;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter('the_password_form', function () {
    $context = Timber::context();
    $context['form'] = [
      'url' => site_url('/wp-login.php?action=postpass', 'login_post')
    ];
    $translatableOptions = Options::getTranslatable('FormPasswordProtection');
    if (!empty($translatableOptions)) {
        $context = array_replace_recursive($context, $translatableOptions);
    }

    return Timber::compile('index.twig', $context);
});

Options::addTranslatable('FormPasswordProtection', [
  [
    'label' => __('General', 'flynt'),
    'name' => 'general',
    'type' => 'tab',
    'placement' => 'top',
    'endpoint' => 0,
  ],
  [
    'label' => __('Content', 'flynt'),
    'name' => 'contentHtml',
    'type' => 'wysiwyg',
    'tabs' => 'visual,text',
    'media_upload' => 0,
    'delay' => 1,
    'default_value' => sprintf(
        '<h1 class="h3">%1$s</h1><p>%2$s %3$s</p>',
        __('Enter Password', 'flynt'),
        __('This content is password protected.', 'flynt'),
        __('To view it please enter your password below:', 'flynt')
    ),
  ],
]);
