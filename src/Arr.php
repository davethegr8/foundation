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

    function remove($array, $values) {
        $values = array_wrap($values);

        foreach($array as $key => $value) {
            if(in_array($value, $values)) {
                unset($array[$key]);
            }
        }

        return array_values($array);
    }
}
