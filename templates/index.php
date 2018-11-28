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
                            'name' => 'ListPosts'
                        ]
                    ],
                    'mainFooter' => [
                        [
                            'name' => 'NavigationFooter',
                            'customData' => [
                                'menuSlug' => 'navigation_footer'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
