<?php

function all() {
    foreach(func_get_args() as $arg) if(!boolval($arg)) return false;
    return true;
}

function any() {
    foreach(func_get_args() as $arg) if(boolval($arg)) return true;
    return false;
}

function dump() {
    echo '<pre>';
    foreach(func_get_args() as $arg) {
        if(is_bool($arg) || $arg === null) {
            echo var_export($arg, true);
        }
        else {
            echo print_r($arg, true);
        }
    }
    echo '</pre>';
}

function array_pluck($key, $array) {
    trigger_error("array_pluck is deprecated - use array_column instead", E_USER_DEPRECATED);
    return array_column($array, $key);
}

function array_collect($keys, $array) {
    return Arr::collect($keys, $array);
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
    return str_replace(' ', '', ucwords(str_replace('_', ' ', lower($str)))); // Heh.
}

/**
 * Creates string composed of random characters from the set (a-zA-Z0-9). Most useful for passwords.
 * @param $length How long the string should be. Defaults to 16.
 * @return A string of length $length filled with random characters.
 */
function randomCharString($length = 16, $chars = NULL) {
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

function create_handle($string) {
    return Str::slugify($string);
}

/* Takes a bunch of parameters and returns the first one that is truthy */
function eor()
{
    foreach (func_get_args() as $arg) {
        if ($arg) {
            return $arg;
        }
    }
}

function lower($str) {
    return Str::lower($str);
}

function upper($str) {
    return Str::upper($str);
}

function _checked($value, $check = null, $return = 'checked') {
    return any(
        ($check !== null && $value == $check),
        ($value && $check === null)
    ) ? $return : '';
}

function _active($value, $check = null)  {
    return _checked($value, $check, 'active');
}

function _selected($value, $check = null) {
    return _checked($value, $check, 'selected');
}

function getHTMLAttrs($tag) {
    preg_match_all('/(\w+)=\"(.+)\"/U', $tag, $matches);
    return array_combine($matches[1], $matches[2]);
}

function redirect($url, $code = null) {
    header("Location: $url", true, $code);
    exit;
}

function now($format = 'Y-m-d H:i:s') {
    return (new DateTime)->format($format);
}

function starts_with($haystack, $needle) {
    return Str::starts_with($haystack, $needle);
}

function ends_with($haystack, $needle) {
    return Str::ends_with($haystack, $needle);
}

function file_extension($filename) {
    return File::extension($filename);
}

function file_name($filename) {
    return File::name($filename);
}

function file_upload($file, $destination) {
    return File::upload($file, $destination);
}

function format_filesize($size) {
    return File::formatSize($size);
}
