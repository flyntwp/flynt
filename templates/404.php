<?php

Flynt\echoHtmlFromConfig([
    'name' => 'DocumentDefault',
    'areas' => [
        'layout' => [
            [
                'name' => 'LayoutSinglePost',
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
                            'name' => 'BlockNotFound'
                        ]
                    ],
                    'mainFooter' => [
                        [
                            'name' => 'NavigationFooter',
                            'customData' => [
                                'menuSlug' => 'navigation_footer'
                            ]
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
