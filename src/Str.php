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
}
