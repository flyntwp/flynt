<?php

use ACFComposer\ACFComposer;
use Flynt\Api;
use Flynt\Defaults;

add_action('Flynt/afterRegisterComponents', function () {
    $layouts = [
        Api::loadFields('AccordionDefault', 'layout'),
        Api::loadFields('BlockImage', 'layout'),
        Api::loadFields('BlockImageText', 'layout'),
        Api::loadFields('BlockVideoOembed', 'layout'),
        Api::loadFields('BlockWysiwyg', 'layout'),
        Api::loadFields('GridContentLists', 'layout'),
        Api::loadFields('GridDownloadPortrait', 'layout'),
        Api::loadFields('GridPosts', 'layout'),
        Api::loadFields('GridPostsSlider', 'layout'),
        Api::loadFields('GridListSteps', 'layout'),
        Api::loadFields('GridTeaserTiles', 'layout'),
        Api::loadFields('HeroCta', 'layout'),
        Api::loadFields('HeroImageText', 'layout'),
        Api::loadFields('ListComponents', 'layout'),
        Api::loadFields('ListFacts', 'layout'),
        Api::loadFields('ListPostCards', 'layout'),
        Api::loadFields('ListSocial', 'layout'),
        Api::loadFields('ListTestimonialCards', 'layout'),
        Api::loadFields('SliderImages', 'layout'),
        Api::loadFields('SliderImageGallery', 'layout'),
    ];

    if (!Defaults::$useGutenberg) {
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
                    'layouts' => $layouts,
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ],
                    [
                        'param' => 'page_type',
                        'operator' => '!=',
                        'value' => 'posts_page',
                    ],
                ],
            ],
        ]);
    } else {
        API::registerBlocks($layouts);
    }
});
