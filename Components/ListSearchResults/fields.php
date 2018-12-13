<?php

use Flynt\Utils\Options;

Options::addTranslatable('ListSearchResults', [
    [
        'label' => 'Title Content',
        'name' => 'searchTitleHtml',
        'type' => 'wysiwyg',
        'required' => 1,
        'default_value' => 'Search Result ',
        'instructions' => 'Title of the search Page.',
        'media_upload' => 0,
        'delay' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
    ],
    [
        'label' => 'Search placholder text',
        'name' => 'searchPlaceholder',
        'type' => 'text',
        'required' => 1,
        'default_value' => 'Search...',
        'instructions' => 'The text for the input field.'
    ],
    [
        'label' => 'Successful search text',
        'name' => 'searchResult',
        'type' => 'wysiwyg',
        'required' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
        'default_value' => 'Es wurden %%resultCount%% Blogeinträge gefunden.',
        'instructions' => 'Sentence for a successful search. The placeholder %%resultCount%% replace the counted results and %%resultTerm%% replace the searching phrase'
    ],
    [
        'label' => 'Unsuccessful text',
        'name' => 'noResults',
        'type' => 'wysiwyg',
        'required' => 1,
        'wrapper' => [
            'class' => 'autosize',
        ],
        'default_value' => 'No results found.',
        'instructions' => 'Sentence for an unsuccessful search. The placeholder %%resultCount%% replace the counted results and %%resultTerm%% replace the searching phrase'
    ]
]);
