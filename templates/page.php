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
                            'name' => 'ComponentLoaderFlexible',
                            'customData' => [
                                'fieldGroup' => 'pageComponents'
                            ]
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
