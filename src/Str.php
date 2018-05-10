<?php

namespace Hep\Foundation;

class Str {

    public static function lower($value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    public static function upper($value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    public static function slug($value)
    {
        return trim(preg_replace('/([^a-z0-9]+)/', '-', self::lower($value)), '-');
    }

    public static function starts_with($haystack, $needle) {
        return strpos($haystack, $needle) === 0;
    }

    public static function ends_with($haystack, $needle) {
        return strrpos($haystack, $needle) + strlen($needle) === strlen($haystack);
    }
}
