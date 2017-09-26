<?php

namespace Hep\Foundation\Database;

use PDO;
use Hep\Foundation\Database;

class SQLite extends Database {
    public function __construct($filename, $options = []) {
        $defaults = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        foreach($options as $key => $value) {
            $defaults[$key] = $value;
        }
        $options = $defaults;

        parent::__construct('sqlite:'.$filename, null, null, $options);
    }
}
