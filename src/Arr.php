<?php

namespace Hep\Foundation;

class Arr {
    static function collect($keys, $array) {
        if(!is_array($keys)) {
            return array_column($array, $keys);
        }

        return array_map(function ($item) use ($keys) {
            return array_combine($keys, array_map(function ($key) use ($item) {
                return array_key_exists($key, $item) ? $item[$key] : null;
            }, $keys));
        }, $array);
    }

    static function remove(array $array, $values) {
        if (!is_array($values)) {
            $values = [$values];
        }
        return array_diff($array, $values);
    }

    public static function dot($array, $prepend = '') {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend.$key.'.'));
            } else {
                $results[$prepend.$key] = $value;
            }
        }

        return $results;
    }
}
