<?php

namespace Hep\Foundation\Database;

use Hep\Foundation\Database;

class MySQL extends Database {

    public function __construct($host, $user = '', $pass = '', $name = '', array $options = []) {
        $dsn = 'mysql:host='.$host.';dbname='.$name;
        parent::__construct($dsn, $user, $pass, $options);
    }

}
