<?php

namespace Hep\Foundation\Database;

use Hep\Foundation\Database;

class Table {
	public $columns = [];
	public $primary = [];

	protected $database;
	protected $table;
	protected $query;
	protected $limit = 20;

	function __construct(Database $database, $table) {
		$this->database = $database;
		$this->table = $table;

		$sql = "DESCRIBE `$this->table`";
		$this->columns = $database->select($sql);

		foreach($this->columns as $column) {
			if($column['Key'] == 'PRI') {
				$this->primary[] = $column['Field'];
			}
		}
	}

	function query($query = null) {
		if($query !== null) {
			$this->query = $query;
		}

		return $this->query;
	}

	function limit($limit = null) {
		if($limit !== null) {
			$this->limit = $limit;
		}

		return $this->limit;
	}

	function count() {
		$where = $this->where();
		$sql = "SELECT COUNT(*) AS `count`
				FROM `{$this->table}`
				$where";
		$data = [];
		if($where) {
			$data['query'] = '%'.$this->query.'%';
		}

		$result = $this->database->selectRow($sql, $data);
		return $result['count'];
	}

	function where() {
		$where = '';
		$search = [];

		foreach($this->columns as $column) {
			$search[] = "`".$this->table."`.`".$column['Field']."` LIKE :query";
		}

		if(count($search)) {
			$where = 'WHERE '.implode(' OR ', $search);
		}

		return $where;
	}
}
