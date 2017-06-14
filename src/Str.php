<?php

namespace Hep\Foundation;

class Str {
    function lower($str) {
        return mb_strtolower($value, 'UTF-8');
    }

    function upper($str) {
        return mb_strtoupper($value, 'UTF-8');
    }

    function starts_with() {
        return ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle);
    }

    function ends_with($haystack, $needle) {
        return (substr($haystack, -strlen($needle)) === (string) $needle);
    }

    /**
     * Removes special characters, lowers, and replaces ' '  with '-', used for
     * creating http url handles
     * @param $string The string you want to create an http handle from
     * @return The handle, with special characters removed.
     */
    function slugify($string) {
        return trim(preg_replace('/([^a-z0-9]+)/', '-', strtolower($string)), '-');
    }
}
