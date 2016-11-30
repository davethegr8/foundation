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
    foreach(func_get_args() as $arg) echo print_r($arg, true);
    echo '</pre>';
}

function array_pluck($key, $array) {
    trigger_error("array_pluck is deprecated - use array_column instead", E_USER_DEPRECATED);
    return array_column($array, $key);
}

function array_collect($keys, $array) {
    if(!is_array($keys)) {
        return array_column($array, $keys);
    }

    return array_map(function ($item) use ($keys) {
        return array_combine($keys, array_map(function ($key) use ($item) {
            return array_key_exists($key, $item) ? $item[$key] : null;
        }, $keys));
    }, $array);
}

/**
 * Rounds to the nearest multiple of $interval. eg 4,8,12 etc
 */
function round_interval($num, $interval) {
    return round($num / $interval) * $interval;
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
function curl_request($url, $opts = []) {
    $default = [
        CURLOPT_RETURNTRANSFER => true
    ];
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

function file_name($filename) {
    return substr($filename, 0, strpos($filename, '.') ?: strlen($filename));
}

/* Takes a bunch of parameters and returns the first one that
is equivalent to bool(true) */
function eor()
{
    foreach (func_get_args() as $arg) {
        if ($arg) {
            return $arg;
        }
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


function _checked($value, $check = null, $return = 'checked') {
    return (($check !== null && $value == $check) || ($value && $check === null) ? $return : '');
}

function _active($value, $check = null)  {
    return _checked($value, $check, 'active');
}

function _selected($value, $check = null) {
    return _checked($value, $check, 'selected');
}

function file_upload($file, $destination) {
    $filename = '';

    if(is_uploaded_file($file['tmp_name'])) {
        $extension = '.'.file_extension($file['name']);
        $filename = md5($file['name']);

        while(file_exists($destination.$filename.$extension)) {
            $filename = md5($filename);
        }

        move_uploaded_file($file['tmp_name'], $destination.$filename.$extension);
    }

    return $filename.$extension;
}

function getHTMLAttrs($tag) {
    preg_match_all('/(\w+)=\"(.+)\"/U', $tag, $matches);
    return array_combine($matches[1], $matches[2]);
}
