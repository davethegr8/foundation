<?php


use PHPUnit\Framework\TestCase;

use Hep\Foundation\Str;

/**
 */
class lowerTest extends TestCase
{
    public function testLowerCase()
    {
        $this->assertEquals(lower('LOWER'), 'lower');
    }
}

