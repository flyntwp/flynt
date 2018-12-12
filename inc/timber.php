<?php

use Flynt\Features\Components\Component;
use Flynt\Utils\Asset;
use function Flynt\Features\TimberLoader\renderTwigIndex;

add_filter('get_twig', function ($twig) {
    $twig->addFunction(new Twig_SimpleFunction('renderComponent', 'renderComponent'));

    $twig->addFunction(new Twig_SimpleFunction('renderFlexibleContent', function ($fcField) {
        return implode('', array_map(function ($field) {
            return renderComponent(ucfirst($field['acf_fc_layout']), $field);
        }, $fcField));
    }));

    return $twig;
});

function renderComponent ($name, $data = [])
{
    $data = apply_filters(
        'Flynt/addComponentData',
        $data,
        [],
        [
            'name' => $name,
        ]
    );
    $data = apply_filters(
        "Flynt/addComponentData?name={$name}",
        $data,
        [],
        [
            'name' => $name,
        ]
    );

    return renderTwigIndex(null, $name, $data, null);
};

add_action('after_setup_theme', function () {
    new Timber\Timber();
});

add_action('Flynt/afterRegisterFeatures', function () {
    add_action('wp_enqueue_scripts', function () {
        Asset::register([
            'name' => 'console-polyfill',
            'type' => 'script',
            'path' => 'vendor/console.js'
        ]);
        Asset::register([
            'name' => 'babel-polyfill',
            'type' => 'script',
            'path' => 'vendor/babel-polyfill.js'
        ]);
        Asset::register([
            'name' => 'document-register-element',
            'type' => 'script',
            'path' => 'vendor/document-register-element.js'
        ]);
        Asset::register([
            'name' => 'normalize',
            'path' => 'vendor/normalize.css',
            'type' => 'style'
        ]);
        Asset::enqueue([
            'name' => 'Flynt/assets',
            'path' => 'assets/script.js',
            'type' => 'script',
            'dependencies' => [
                'console-polyfill',
                'babel-polyfill',
                'document-register-element',
            ],
        ]);
        Asset::enqueue([
            'name' => 'Flynt/assets',
            'path' => 'assets/style.css',
            'type' => 'style',
            'dependencies' => [
                'normalize',
            ],
        ]);

        // separately enqueued after components script.js to being able
        // to set global config variables before lazysizes is loaded
        Asset::enqueue([
            'name' => 'lazysizes',
            'type' => 'script',
            'path' => 'vendor/lazysizes.js'
        ]);
    });
});
