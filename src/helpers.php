<?php

use Hep\Foundation\Arr;
use Hep\Foundation\File;
use Hep\Foundation\HTML;
use Hep\Foundation\Http;

/**
 * @codeCoverageIgnore
 */
function is_cli() {
    return php_sapi_name() == "cli";
}

function all() {
    foreach(func_get_args() as $arg) if(!boolval($arg)) return false;
    return true;
}

function any() {
    foreach(func_get_args() as $arg) if(boolval($arg)) return true;
    return false;
}

function dump() {
    // @codeCoverageIgnoreStart
    if(!is_cli()) {
        echo '<pre>';
    }
    // @codeCoverageIgnoreEnd

    foreach(func_get_args() as $arg) {
        if(is_bool($arg) || $arg === null) {
            echo var_export($arg, true);
        }
        else {
            echo print_r($arg, true);
        }

        // @codeCoverageIgnoreStart
        if(is_cli()) {
            echo PHP_EOL;
        }
        // @codeCoverageIgnoreEnd
    }

    // @codeCoverageIgnoreStart
    if(!is_cli()) {
        echo '</pre>';
    }
    // @codeCoverageIgnoreEnd
}

function array_collect($keys, $array) {
    return Arr::collect($keys, $array);
}

function array_remove($array, $values) {
    return Arr::remove($array, $values);
}

/**
 * Rounds to the nearest multiple of $interval. eg 4,8,12 etc
 */
function round_interval($num, $interval) {
    return round($num / $interval) * $interval;
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
    return \Illuminate\Support\Str::lower($str);
}

function upper($str) {
    return \Illuminate\Support\Str::upper($str);
}

function checked($value, $check = null, $return = 'checked') {
    return HTML::checked($value, $check, $return);
}

function active($value, $check = null)  {
    return HTML::active($value, $check);
}

function selected($value, $check = null) {
    return HTML::selected($value, $check);
}

function getHTMLAttrs($tag) {
    return HTML::getAttrs($tag);
}

function redirect($url, $code = 302) {
    Http::redirect($url, $code);
}

function now($format = 'Y-m-d H:i:s') {
    return (new DateTime)->format($format);
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
