<?php

use Flynt\Utils\Options;

Options::addGlobal('Acf', [
    [
        'name' => 'googleMapsTab',
        'label' => 'Google Maps',
        'type' => 'tab'
    ],
    [
        'name' => 'googleMapsApiKey',
        'label' => 'Google Maps Api Key',
        'type' => 'text',
        'maxlength' => 100,
        'prepend' => '',
        'append' => '',
        'placeholder' => ''
    ]
]);
