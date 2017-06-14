<?php

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
