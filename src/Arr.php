<?php

namespace Hep\Foundation;

class Arr {
    function collect($keys, $array) {
        if(!is_array($keys)) {
            return array_column($array, $keys);
        }

        return array_map(function ($item) use ($keys) {
            return array_combine($keys, array_map(function ($key) use ($item) {
                return array_key_exists($key, $item) ? $item[$key] : null;
            }, $keys));
        }, $array);
    }

    function flatten($array, $joiner = '.', $prepend = '') {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && ! empty($value)) {
                $results = array_merge(
                    $results,
                    static::flatten($value, $joiner, $prepend.$key.$joiner)
                );
            } else {
                $results[$prepend.$key] = $value;
            }
        }
        return $results;
    }
}
