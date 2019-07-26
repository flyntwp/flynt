<?php

use ACFComposer\ACFComposer;
use Flynt\Api;

add_action('Flynt/afterRegisterComponents', function () {
    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Components',
        'style' => 'seamless',
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => 'Page Components',
                'type' => 'flexible_content',
                'button_label' => 'Add Component',
                'layouts' => [
                    Api::loadFields('AccordionDefault', 'layout'),
                    Api::loadFields('BlockCountUp', 'layout'),
                    Api::loadFields('BlockImage', 'layout'),
                    Api::loadFields('BlockImageText', 'layout'),
                    Api::loadFields('BlockImageTextParallax', 'layout'),
                    Api::loadFields('BlockImageTextCta', 'layout'),
                    Api::loadFields('BlockTextImageCrop', 'layout'),
                    Api::loadFields('BlockVideoOembed', 'layout'),
                    Api::loadFields('BlockWysiwyg', 'layout'),
                    Api::loadFields('BlockWysiwygTwoCol', 'layout'),
                    Api::loadFields('BlockWysiwygSidebar', 'layout'),
                    Api::loadFields('GridContentLists', 'layout'),
                    Api::loadFields('GridDownloadPortrait', 'layout'),
                    Api::loadFields('GridImageText', 'layout'),
                    Api::loadFields('GridListSteps', 'layout'),
                    Api::loadFields('GridPostsSlider', 'layout'),
                    Api::loadFields('GridPostsLatest', 'layout'),
                    Api::loadFields('GridPostsTeaser', 'layout'),
                    Api::loadFields('GridTeaserTiles', 'layout'),
                    Api::loadFields('HeroCta', 'layout'),
                    Api::loadFields('HeroImageCta', 'layout'),
                    Api::loadFields('HeroImageText', 'layout'),
                    Api::loadFields('HeroTextImage', 'layout'),
                    Api::loadFields('ListComponents', 'layout'),
                    Api::loadFields('ListLogos', 'layout'),
                    Api::loadFields('ListIcons', 'layout'),
                    Api::loadFields('ListSocial', 'layout'),
                    Api::loadFields('ListTestimonialCards', 'layout'),
                    Api::loadFields('SliderImages', 'layout'),
                    Api::loadFields('SliderImagesCentered', 'layout'),
                    Api::loadFields('SliderImageGallery', 'layout')
                ]
            ]
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page'
                ],
                [
                    'param' => 'page_type',
                    'operator' => '!=',
                    'value' => 'posts_page'
                ]
            ]
        ]
    ]);
});
