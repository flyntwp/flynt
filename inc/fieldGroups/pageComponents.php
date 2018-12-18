<?php

use ACFComposer\ACFComposer;

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
                    Flynt\loadFields('AccordionDefault', 'layout'),
                    Flynt\loadFields('BlockImage', 'layout'),
                    Flynt\loadFields('BlockImageText', 'layout'),
                    Flynt\loadFields('BlockMediaText', 'layout'),
                    Flynt\loadFields('BlockVideoOembed', 'layout'),
                    Flynt\loadFields('BlockWysiwyg', 'layout'),
                    Flynt\loadFields('GridContentLists', 'layout'),
                    Flynt\loadFields('GridDownloadPortrait', 'layout'),
                    Flynt\loadFields('GridPosts', 'layout'),
                    Flynt\loadFields('GridPostsSlider', 'layout'),
                    Flynt\loadFields('GridListSteps', 'layout'),
                    Flynt\loadFields('HeroCta', 'layout'),
                    Flynt\loadFields('HeroImage', 'layout'),
                    Flynt\loadFields('HeroImageText', 'layout'),
                    Flynt\loadFields('ListComponents', 'layout'),
                    Flynt\loadFields('ListFacts', 'layout'),
                    Flynt\loadFields('ListPostCards', 'layout'),
                    Flynt\loadFields('ListSocial', 'layout'),
                    Flynt\loadFields('ListTestimonialCards', 'layout'),
                    Flynt\loadFields('SliderMedia', 'layout'),
                    Flynt\loadFields('SliderImages', 'layout'),
                    Flynt\loadFields('SliderImageGallery', 'layout'),
                ],
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
});
