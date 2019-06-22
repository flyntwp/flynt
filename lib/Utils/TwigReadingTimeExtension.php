<?php

namespace Flynt\Utils;

use Twig_Extension;
use Twig_SimpleFilter;

class TwigReadingTimeExtension extends Twig_Extension
{
    public function getName()
    {
        return 'ReadingTime';
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('readingtime', [$this, 'readingtimeFilter'])
        ];
    }

    public function readingtimeFilter($content)
    {
        $wordsPerMinute = 200;
        $words = str_word_count(strip_tags($content));
        $minutesToRead = floor($words / $wordsPerMinute);
        $min = ($minutesToRead < 1 ? '1' : $minutesToRead);

        return $min;
    }
}
