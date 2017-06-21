<?php


use PHPUnit\Framework\TestCase;

/**
 */
final class allTest extends TestCase
{
    public function testHasOneFalseValue()
    {
        $this->assertEquals(any(false, [], 1), true);
    }

    public function testHasNoFalseValues()
    {
        $this->assertEquals(all(true, [1], 1), true);
    }
}

