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

//Takes a underscore string (lang_sname) and transforms it into a camelCase function (langSname)
function camelCase($str) {
    return lcfirst(TitleCase($str));
}

//Takes a underscore string (lang_sname) and transforms it into a TitleCase function (LangSname)
function TitleCase($str) {
    return str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($str)))); // Heh.
}

/**
 * Creates string composed of random characters from the set (a-zA-Z0-9). Most useful for passwords.
 * @param $length How long the string should be. Defaults to 8.
 * @return A string of length $length filled with random characters.
 */
function randomCharString($length = 8, $chars = NULL) {
    $length = intval($length);
    $output = '';

    if($chars === NULL) {
        $chars = array_merge(range(0, 9), range("a", "z"), range("A", "Z"));
    }

    while($length-- > 0) {
        $output .= $chars[rand(0, count($chars) - 1)];
    }

    return $output;
}
