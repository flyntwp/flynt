<?php

namespace Flynt\Components\BlockSocialShare;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BlockSocialShare', function ($data) {

    global $post;

    $post_url      = get_the_permalink($post->ID);
    $post_title    = rawurlencode(get_the_title($post->ID) . ' - ' . get_bloginfo('name'));

    $data['facebookUrl'] = 'https://www.facebook.com/sharer.php?u=' . $post_url;
    $data['twitterUrl'] = 'https://twitter.com/intent/tweet?url=' . $post_url . '&text=' . $post_title;
    $data['linkedinUrl'] = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $post_url;
    $data['emailUrl'] = 'mailto:?subject=' . $post_title . '&body=' . $post_url;

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'blockSocialShare',
        'label' => 'Block: Social Share',
        'sub_fields' => [
            [
                'label' => __('General', 'flynt'),
                'name' => 'generalTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'label' => __('Facebook', 'flynt'),
                'name' => 'facebookShare',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ],
            [
                'label' => __('Twitter', 'flynt'),
                'name' => 'twitterShare',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ],
            [
                'label' => __('LinkedIn', 'flynt'),
                'name' => 'linkedinShare',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ],
            [
                'label' => __('Email', 'flynt'),
                'name' => 'emailShare',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ],
            [
                'label' => __('Options', 'flynt'),
                'name' => 'optionsTab',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0
            ],
            [
                'label' => '',
                'name' => 'options',
                'type' => 'group',
                'layout' => 'row',
                'sub_fields' => [
                    FieldVariables\getTheme()
                ]
            ]
        ]
    ];
}
