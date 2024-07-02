<?php

namespace Flynt\Utils;

/**
 * Provides a set of methods that are used to manipulate strings.
 */
class StringHelpers
{
    /**
     * Converts a string from camel case to kebab case.
     *
     * @since 0.1.0
     *
     * @param string $str The string to convert.
     */
    public static function camelCaseToKebab(string $str): string
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z0-9])/', '$1-', $str));
    }

    /**
     * Strips all HTML tags including script and style,
     * and trims text to a certain number of words.
     *
     * @since 0.1.0
     *
     * @param string $str The string to trim and strip.
     * @param integer $length The string length to return.
     *
     * @return string
     */
    public static function trimStrip(string $str = '', ?int $length = 25)
    {
        return wp_trim_words(wp_strip_all_tags($str), $length, '&hellip;');
    }

    /**
     * Splits a camel case string.
     *
     * @since 0.1.0
     *
     * @param string $str The string to split.
     */
    public static function splitCamelCase(string $str): string
    {
        $a = preg_split('/(^[^A-Z]+|[A-Z][^A-Z]+)/', $str, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        return implode(' ', $a);
    }

    /**
     * Converts a string from kebap case to camel case.
     *
     * @since 0.1.0
     *
     * @param string $str The string to convert.
     * @param boolean $capitalizeFirstCharacter Sets if the first character should be capitalized.
     *
     * @return string
     */
    public static function kebapCaseToCamelCase(string $str, ?bool $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
        if (false === $capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    /**
     * Removes a prefix from a string.
     *
     * @since 0.1.0
     *
     * @param string $prefix The prefix to be removed.
     * @param string $str The string to manipulate.
     */
    public static function removePrefix(string $prefix, string $str): string
    {
        if (substr($str, 0, strlen($prefix)) === $prefix) {
            return substr($str, strlen($prefix));
        }

        return $str;
    }

    /**
     * Checks if a string starts with a certain string.
     *
     * @since 0.1.0
     *
     * @param string $search The string to search for.
     * @param string $subject The string to look into.
     *
     * @return boolean Returns true if the subject string starts with the search string.
     */
    public static function startsWith(string $search, string $subject): bool
    {
        return substr($subject, 0, strlen($search)) === $search;
    }

    /**
     * Checks if a string ends with a certain string.
     *
     * @since 0.1.0
     *
     * @param string $search The string to search for.
     * @param string $subject The string to look into.
     *
     * @return boolean Returns true if the subject string ends with the search string.
     */
    public static function endsWith(string $search, string $subject): bool
    {
        $searchLength = strlen($search);
        $subjectLength = strlen($subject);
        if ($searchLength > $subjectLength) {
            return false;
        }

        return substr_compare($subject, $search, $subjectLength - $searchLength, $searchLength) === 0;
    }
}
