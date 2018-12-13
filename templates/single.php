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
                            'name' => 'NavigationMain'
                        ]
                    ],
                    'pageComponents' => [
                        [
                            'name' => 'ComponentLoaderFlexible',
                            'customData' => [
                                'fieldGroup' => 'postComponents'
                            ]
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
