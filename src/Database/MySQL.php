<?php

namespace Hep\Foundation\Database;

use Hep\Foundation\Database;

class MySQL extends Database {

	public function __construct(array $dsn = [], $username = '', $password = '', array $options = []) {
		$defaults = [
			'host' => null,
			'port' => null,
			'dbname' => null,
			'unix_socket' => null,
			'charset' => null
		];

		$dsn = array_replace_recursive($defaults, $dsn);
		$dsn = array_filter($dsn);

		$dsn = array_map(function ($key, $value) {
			return $key.'='.$value;
		}, array_keys($dsn), $dsn);

		$dsn = 'mysql:'.implode(';', $dsn);

		parent::__construct($dsn, $username, $password, $options);
	}
}
