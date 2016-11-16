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

/**
 * Downloads the contents of the file at $url. This is basically a replacement
 * for file_get_contents($url) or fopen($url) on systems that have those functions
 * disabled for http streams.
 *
 * @param $url The url to fetch
 * @param $verifypeer [optional] The status of CURLOPT_SSL_VERIFYPEER. Set to false
 * by default due to an empty on SSL encrypted sites when the client cannot verify
 * the site's authenticity. Set to true for extra security.
 * @return The contents of the file at $url
 */
function curl_request($url, $opts = array()) {
    $default = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    );
    foreach($opts as $key => $value) {
        $default[$key] = $value;
    }
    $opts = $default;

    $http = curl_init($url);
    foreach($opts as $key => $value) {
        curl_setopt($http, $key, $value);
    }

    $response = curl_exec($http);
    curl_close($http);

    return $response;
}

/**
 * Removes special characters, lowers, and replaces ' '  with '-', used for
 * creating http url handles
 * @param $string The string you want to create an http handle from
 * @return The handle, with special characters removed.
 */
function create_handle($string) {
    return trim(preg_replace('/([^a-z0-9]+)/', '-', strtolower($string)), '-');
}

function file_extension($filename) {
    if(strrpos($filename, '.') !== false) {
        return substr($filename, strrpos($filename, '.') + 1);
    }
}

/* Takes a bunch of parameters and returns the first one that
is equivalent to bool(true) */
function eor() {
    $args = func_get_args();
    foreach($args as $arg) {
        if($arg) return $arg;
    }
}

//pass by ref to save memory
function lower($str) {
    return strtolower($str);
}

//pass by ref to save memory
function upper($str) {
    return strtoupper($str);
}
