<?php


use PHPUnit\Framework\TestCase;

/**
 */
class upperTest extends TestCase
{
    public function testLowerCase()
    {
        $this->assertEquals(upper('upper'), 'UPPER');
    }
}

