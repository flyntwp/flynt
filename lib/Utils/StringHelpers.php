<?php

namespace Flynt\Utils;

class StringHelpers
{
    public static function camelCaseToKebap($str)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $str));
    }

    public static function trimStrip($str, $length = 25)
    {
        if (isset($str)) {
            return wp_trim_words(wp_strip_all_tags($str), $length, '...');
        }
    }

    public static function splitCamelCase($str)
    {
        $a = preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
            $str,
            -1, /* no limit for replacement count */
            PREG_SPLIT_NO_EMPTY /*don't return empty elements*/
            | PREG_SPLIT_DELIM_CAPTURE /*don't strip anything from output array*/
        );
        return implode($a, ' ');
    }

    public static function kebapCaseToCamelCase($str, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    public static function removePrefix($prefix, $str)
    {
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            return substr($str, strlen($prefix));
        }
        return $str;
    }

    public static function startsWith($search, $subject)
    {
        return substr($subject, 0, strlen($search)) === $search;
    }
}
