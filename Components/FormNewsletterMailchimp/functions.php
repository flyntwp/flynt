<?php

namespace Flynt\Components\FormNewsletterMailchimp;

use Flynt\Api;
use Flynt\Utils\Options;

Api::registerFields('FormNewsletterMailchimp', [
    'layout' => [
        'name' => 'formNewsletterMailchimp',
        'label' => 'Form: Newsletter Mailchimp',
        'sub_fields' => [
        ],
    ],
]);


add_action('Flynt/afterRegisterComponents', function () {
    Options::addTranslatable('FormNewsletterMailchimp', array_merge(
        Api::loadFields('FormContactForm7', 'layout.sub_fields')
    ));
});
