<?php


use PHPUnit\Framework\TestCase;

/**
 */
class anyTest extends TestCase
{
    public function testHasFalseValues()
    {
        $this->assertEquals(all(false, [0], 0), false);
    }

    public function testHasTrueValues()
    {
        $this->assertEquals(all(true, [1], 1), true);
    }
}

