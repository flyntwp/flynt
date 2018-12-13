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
                            'name' => 'BlockBaseStyle'
                        ]
                    ],
                    'mainFooter' => [
                        [
                            'name' => 'NavigationFooter'
                        ]
                    ]
                ]
            ]
        ]
    ]
]);
