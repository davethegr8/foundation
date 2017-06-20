<?php

namespace Hep\Foundation;

class Http {
    function redirect($url, $code = 302) {
        header("Location: $url", true, $code);
        exit;
    }
}
