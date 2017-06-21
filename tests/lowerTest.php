<?php


use PHPUnit\Framework\TestCase;

/**
 */
final class lowerTest extends TestCase
{
    public function testLowerCase()
    {

        $this->assertEquals(lower('LOWER'), 'lower');
    }
}

