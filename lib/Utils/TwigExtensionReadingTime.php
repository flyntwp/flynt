<?php

namespace Flynt\Utils;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Creates the reading time filter to use them in Twig files.
 */
class TwigExtensionReadingTime extends AbstractExtension
{
    /**
     *  Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters()
    {
        return [
            new TwigFilter('readingtime', [$this, 'renderMinutesToRead']),
        ];
    }

    /**
     * Render minutes to read.
     *
     * @param string $content The content from that the minutes to read should be calculated.
     *
     * @return integer The minutes to read.
     */
    public function renderMinutesToRead(string $content): int
    {
        $wordsPerMinute = 200;
        $words = str_word_count(strip_tags($content));
        $minutesToRead = floor($words / $wordsPerMinute);
        $min = $minutesToRead < 1 ? '1' : $minutesToRead;

        return (int)$min;
    }
}
