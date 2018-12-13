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
                            'name' => 'NavigationMain'
                        ]
                    ],
                    'pageComponents' => [
                        [
                            'name' => 'GridPosts'
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
