<?php

namespace Hep\Foundation;

class Str {
    function lower($str) {
        return mb_strtolower($value, 'UTF-8');
    }

    function upper($str) {
        return mb_strtoupper($value, 'UTF-8');
    }
}
