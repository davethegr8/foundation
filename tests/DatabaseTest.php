<?php

use PHPUnit\Framework\TestCase;

use Hep\Foundation\Database\SQLite;

/**
 * select(), selectRow() and selectValue() defaulted $fetch_style to null, which
 * PHP 8.1 reports as a deprecation on every query ("Passing null to parameter
 * #1 ($mode) of type int"). PHP prints that ahead of the response body, so a
 * web app using the library got notices in front of its JSON. phpunit.xml.dist
 * turns deprecations into failures, so these fail if it comes back.
 */
class DatabaseTest extends TestCase
{
    protected $db;

    public function setUp(): void {
        $this->db = new SQLite(':memory:');
        $this->db->exec('CREATE TABLE things (id INTEGER PRIMARY KEY, name TEXT)');
        $this->db->insert('things', ['name' => 'one']);
        $this->db->insert('things', ['name' => 'two']);
    }

    public function testSelectUsesTheConnectionsDefaultFetchMode() {
        $this->assertEquals([
            ['id' => 1, 'name' => 'one'],
            ['id' => 2, 'name' => 'two'],
        ], $this->db->select('SELECT * FROM things ORDER BY id'));
    }

    public function testSelectRow() {
        $this->assertEquals(
            ['id' => 2, 'name' => 'two'],
            $this->db->selectRow('SELECT * FROM things WHERE id = :id', ['id' => 2])
        );
    }

    public function testSelectValue() {
        $this->assertEquals('two', $this->db->selectValue('SELECT name FROM things WHERE id = :id', ['id' => 2]));
    }

    public function testAnExplicitFetchStyleIsStillHonored() {
        $this->assertEquals(
            [[1, 'one'], [2, 'two']],
            $this->db->select('SELECT * FROM things ORDER BY id', [], PDO::FETCH_NUM)
        );
    }
}
