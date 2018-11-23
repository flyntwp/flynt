<?php

namespace Flynt\Features\YoastToBottom;

function init()
{
    return 'low';
}

add_filter('wpseo_metabox_prio', 'Flynt\Features\YoastToBottom\init');
