<?php

namespace Flynt;

class Helpers
{
    public static function extractNestedDataFromArray($args = [])
    {
        if (count($args) < 2) {
            return self::returnEmptyStringOrFirstArgument($args);
        }
        $key = array_pop($args);
        $data = self::returnFirstArgumentOrNestedData($args);
        return self::accessArrayOrObject($key, $data);
    }

    protected static function returnEmptyStringOrFirstArgument($args = [])
    {
        if (count($args) === 0) {
            return '';
        }
        if (count($args) === 1) {
            return $args[0];
        }
    }

    protected static function returnFirstArgumentOrNestedData($args = [])
    {
        if (count($args) > 1) {
            return self::extractNestedDataFromArray($args);
        } else {
            return $args[0];
        }
    }

    protected static function accessArrayOrObject($key, $data)
    {
        $output = '';
        if (is_array($key) || is_object($key)) {
            $output = $key;
        } elseif (is_array($data) && array_key_exists($key, $data)) {
            $output = $data[$key];
        } elseif (is_object($data) && property_exists($data, $key)) {
            $output = $data->$key;
        }
        return $output;
    }
}
