<?php

namespace Flynt\Utils;

use Twig_Extension;
use Twig\TwigFilter;

class TwigReadingTimeExtension extends Twig_Extension
{
    public function getName()
    {
        return 'ReadingTime';
    }

    public function getFilters()
    {
        return [
            new TwigFilter('readingtime', [$this, 'readingtimeFilter'])
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
