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
