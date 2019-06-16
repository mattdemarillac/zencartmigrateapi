<?php

namespace Elvanto\Util;

class Arr
{
    public static function groupByProperty(array $arr, $property)
    {
        $result = [];

        foreach ($arr as $item) {
            $result[$item->$property][] = $item;
        }

        return $result;
    }

    public static function groupByKey(array $arr, $key)
    {
        $result = [];

        foreach ($arr as $item) {
            $result[$item[$key]][] = $item;
        }

        return $result;
    }

    public static function flatten($arr)
    {
        $result = [];

        foreach ($arr as $offset => $value) {
            if (is_array($value) && is_int(key($value))) {
                $result = array_merge($result, self::flatten($value));
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }

    public static function filterByPropertyValue(array $arr, $property, $value)
    {
        return array_values(array_filter($arr, function($item) use ($property, $value) {
            return $item->$property == $value;
        }));
    }

    public static function filterByKeyValue(array $arr, $key, $value)
    {
        return array_values(array_filter($arr, function($item) use ($key, $value) {
            return $item[$key] == $value;
        }));
    }

    public static function findByPropertyValue(array $arr, $property, $value)
    {
        foreach ($arr as $item) {
            if ($item->$property == $value) {
                return $item;
            }
        }
    }

    public static function findByKeyValue(array $arr, $key, $value)
    {
        foreach ($arr as $item) {
            if ($item[$key] == $value) {
                return $item;
            }
        }
    }

    public static function sumByProperty(array $arr, $property)
    {
        $result = 0;

        foreach ($arr as $item) {
            $result += $item->$property;
        }

        return $result;
    }

    public static function sumByKey(array $arr, $key)
    {
        $result = 0;

        foreach ($arr as $item) {
            $result += $item[$key];
        }

        return $result;
    }

    /**
     * Returns all elements in array a for which no elements in
     * array b exist with the same value for keys.
     *
     * @param array    $a
     * @param array    $b
     * @param string[] $keys
     * @return array
     */
    public static function diffByKeys(array $a, array $b, array $keys)
    {
        $keys = array_flip($keys);

        return array_udiff($a, $b, function($x, $y) use ($keys) {
            return implode(':', array_intersect_key($x, $keys)) <=> implode(':', array_intersect_key($y, $keys));
        });
    }

    /**
     * Returns all elements in array a for which an element in array
     * b exists with the same value for keys.
     *
     * @param array    $a
     * @param array    $b
     * @param string[] $keys
     * @return array
     */
    public static function intersectByKeys(array $a, array $b, array $keys)
    {
        $keys = array_flip($keys);

        return array_uintersect($a, $b, function($x, $y) use ($keys) {
            return implode(':', array_intersect_key($x, $keys)) <=> implode(':', array_intersect_key($y, $keys));
        });
    }
}

