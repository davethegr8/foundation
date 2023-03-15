<?php

namespace Hep\Foundation;

use PDO;

class Database extends PDO {

    public function select($sql, $params = [], $fetch_style = PDO::FETCH_DEFAULT) {
        $statement = $this->prepare($sql);
        $statement->execute($params);
        return $statement->fetchAll($fetch_style);
    }

    public function selectRow($sql, $params = [], $fetch_style = PDO::FETCH_DEFAULT) {
        $statement = $this->prepare($sql);
        $statement->execute($params);
        return $statement->fetch($fetch_style);
    }

    public function selectValue($sql, $params = [], $fetch_style = PDO::FETCH_DEFAULT) {
        $row = $this->selectRow($sql, $params, $fetch_style);
        return array_shift($row);
    }

    public function insert($table, $data)
    {
        $sql = $this->getInsertSQL($table, $data);
        $statement = $this->prepare($sql);
        return $statement->execute($data);
    }

    public function update($table, $data, $where)
    {
        $sql = $this->getUpdateSQL($table, $data, $where);
        $statement = $this->prepare($sql);
        return $statement->execute($data);
    }

    public function delete($table, $data, $where)
    {
        $sql = "DELETE FROM `$table` WHERE $where";
        $statement = $this->prepare($sql);
        return $statement->execute($data);
    }

    public function replace($table, $data)
    {
        $sql = $this->getReplaceSQL($table, $data);
        $statement = $this->prepare($sql);
        return $statement->execute($data);
    }

    public function getInsertSQL($table, $data) {
        $columns = implode(', ', array_map(function($key) {
            return '`'.$key.'`';
        }, array_keys($data)));
        $values = implode(', ', array_map(function($key) {
            return ':'.$key;
        }, array_keys($data)));

        return "INSERT INTO `$table` ( $columns ) VALUES ( $values )";
    }

    public function getUpdateSQL($table, $data, $where)
    {
        $updates = implode(', ', array_map(function ($key, $value) {
            return '`'.$key.'` = :'.$key;
        }, array_keys($data), $data));

        return "UPDATE `$table` SET $updates WHERE $where";
    }

    public function getReplaceSQL($table, $data)
    {
        $columns = implode(', ', array_map(function ($key) {
            return '`'.$key.'`';
        }, array_keys($data)));

        $values = implode(', ', array_map(function($key) {
            return ':'.$key;
        }, array_keys($data)));

        return "REPLACE INTO `$table` ( $columns ) VALUES ( $values )";
    }

    public function insertId() {
        return $this->lastInsertId();
    }

    public function tables() {
        $sql = "SHOW TABLES";
        return $this->select($sql);
    }

    public function describe($table) {
        $sql = "DESCRIBE `$table`";
        return $this->select($sql);
    }

}
