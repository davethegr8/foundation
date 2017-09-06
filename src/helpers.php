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
function curl_request($url, $opts = [], $headers = []) {
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

    if(count($headers)) {
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
    }

    $response = curl_exec($http);
    curl_close($http);

    return $response;
}

function postJSON($url, $data) {
    $data = json_encode($data);

    $opts = [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
    ];

    $headers = [
        'Content-Type: application/json',
        'Content-Length: '.strlen($data)
    ];

    return curl_request($url, $opts, $headers);
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

function text_only($string) {
    $string = preg_replace('/<br(.*)>|<ul(.*)>|<ol(.*)>|<\/p>|<\/h[1-6]>|<\/div>|<hr(.*)>/Ui', "\n", $string);

    $string = preg_replace('/<li(.*)>(.*)<\/li>/Ui', "* $2\n", $string);
    return strip_tags($string);
}


function dateFormat($date, $format = 'n/j/y', $offset = '') {
    return (strtotime($date) !== false ? date($format, strtotime($date.' '.$offset)) : '');
}

function array_extend() {
    $extended = [];
    $args = func_get_args();

    if(empty($args)) {
        return $extended;
    }

    foreach($args as $arg) {
        if(!is_array($arg)) {
            continue;
        }

        foreach($arg as $key => $value) {
            if(is_array($value)) {
                $extended[$key] = array_extend($extended[$key], $value);
            }
            else {
                $extended[$key] = $value;
            }
        }
    }

    return $extended;
}

