<?php

function all() {
    foreach(func_get_args() as $arg) if(!boolval($arg)) return false;
    return true;
}

function any() {
    foreach(func_get_args() as $arg) if(boolval($arg)) return true;
    return false;
}

function debug() {
    echo '<pre>';
    foreach(func_get_args() as $arg) print_r($arg);
    echo '</pre>';
}

function array_pluck($key, $array) {
    return array_map(function ($item) use ($key) {
        return $item[$key];
    }, $array);
}

/**
 * Rounds to the nearest multiple of $interval. eg 4,8,12 etc
 */
function round_interval($num, $interval) {
    return round($num / $interval) * $interval;
}

if(!function_exists('microtime_float')) {
    function microtime_float()  {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
