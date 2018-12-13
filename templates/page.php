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
                                'fieldGroup' => 'pageComponents'
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
