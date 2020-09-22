<?php

/**
 * Defines components
 */

namespace Flynt\SetComponents;

use Flynt\Components;

function getCoreComponents()
{
    return [
        Components\BlockCollapse\getACFLayout(),
        Components\BlockImageText\getACFLayout(),
        Components\BlockImage\getACFLayout(),
        Components\BlockReusable\getACFLayout(),
        Components\BlockVideoOembed\getACFLayout(),
        Components\BlockWysiwyg\getACFLayout(),
        Components\GridImageText\getACFLayout(),
        Components\GridPostsLatest\getACFLayout(),
        Components\ListComponents\getACFLayout(),
        Components\SliderImages\getACFLayout(),
    ];
}

function getPageComponents()
{
    return getCoreComponents();
}

function getPostComponents()
{
    return [
        Components\BlockCollapse\getACFLayout(),
        Components\BlockImage\getACFLayout(),
        Components\BlockImageText\getACFLayout(),
        Components\BlockVideoOembed\getACFLayout(),
        Components\BlockWysiwyg\getACFLayout(),
        Components\SliderImages\getACFLayout(),
    ];
}

function getReusableComponents()
{
    return getCoreComponents();
}
