<?php

namespace Hep\Foundation\Database;

use Hep\Foundation\Database;

class MySQL extends Database {

    public function __construct($host, $user = '', $pass = '', $name = '', array $options = []) {
        $dsn = 'mysql:host='.$host.';dbname='.$name.';charset=UTF8';
        parent::__construct($dsn, $user, $pass, $options);
    }

}
