<?php

use PHPUnit\Framework\TestCase;

use Hep\Foundation\Arr;

/**
 */
class ArrTest extends TestCase
{

    public function testBase() {
        $this->assertEquals(array_collect('collect', [
            ['collect' => true, 'miss' => false],
            ['collect' => false, 'miss' => false]
        ]), [true, false]);
    }

    public function testMulti() {
        $this->assertEquals(array_collect(['one', 'two'], [
            ['one' => 1, 'two' => 2, 'miss' => 0],
            ['one' => 1, 'two' => 2, 'miss' => 0]
        ]), [
            ['one' => 1, 'two' => 2],
            ['one' => 1, 'two' => 2]
        ]);
    }

    public function testRemove() {
        $this->assertEquals(
            array_remove(['one', 'two', 'remove'], ['remove']),
            ['one', 'two']
        );
    }

}

