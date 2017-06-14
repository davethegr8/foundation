<?php

function file_extension($filename) {
    if(strrpos($filename, '.') !== false) {
        return substr($filename, strrpos($filename, '.') + 1);
    }
}

function file_name($filename) {
    return substr($filename, 0, strpos($filename, '.') ?: strlen($filename));
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

function format_filesize($size) {
    $mod = 1024;
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    return round($size, 2).' '.$units[$i];
}
