<?php

Flynt\echoHtmlFromConfig([
    'name' => 'DocumentDefault',
    'areas' => [
        'layout' => [
            [
                'name' => 'LayoutMultiplePosts',
                'areas' => [
                    'mainHeader' => [
                        [
                            'name' => 'NavigationMain',
                            'customData' => [
                                'menuSlug' => 'navigation_main'
                            ]
                        ]
                    ],
                    'pageComponents' => [
                        [
                            'name' => 'ListSearchResults'
                        ]
                    ],
                    'mainFooter' => [
                        [
                            'name' => 'NavigationFooter'
                        ],
                        [
                            'name' => 'BlockCookieNotice'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
