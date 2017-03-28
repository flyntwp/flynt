<?php

namespace Flynt\Utils;

class ArrayHelpers
{
    public static function isAssoc(array $array)
    {
        // Keys of the array
        $keys = array_keys($array);

        // If the array keys of the keys match the keys, then the array must
        // not be associative (e.g. the keys array looked like {0:0, 1:1...}).
        return array_keys($keys) !== $keys;
    }

    // only converts first dimension of object
    public static function objectToArray($obj)
    {
        return array_map(function ($val) {
            return (array) $val;
        }, $obj);
    }

    public static function indexedValuesToAssocKeys(array $array)
    {
        $values = array_map(function ($value) {
            return is_array($value) ? $value : [];
        }, $array);

        $keys = array_map(function ($key) use ($array) {
            return is_int($key) ? $array[$key] : $key;
        }, array_keys($array));

        return array_combine($keys, $values);
    }
}
