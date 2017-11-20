<?php

namespace Hep\Foundation\Database;

use Hep\Foundation\Database;

use PDO;

class MySQL extends Database {

    public function __construct($host, $user = '', $pass = '', $name = '', array $options = []) {
        $defaults = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $options = array_extend($defaults, $options);

        $dsn = 'mysql:host='.$host.';dbname='.$name.';charset=utf8';
        parent::__construct($dsn, $user, $pass, $options);
    }
}
