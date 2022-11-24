<?php

namespace Flynt\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigExtensionReadingTime extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('readingtime', [$this, 'renderMinutesToRead']),
        ];
    }

    public function renderMinutesToRead($content)
    {
        $wordsPerMinute = 200;
        $words = str_word_count(strip_tags($content));
        $minutesToRead = floor($words / $wordsPerMinute);
        $min = $minutesToRead < 1 ? '1' : $minutesToRead;

        return $min;
    }
}
