<?php


use PHPUnit\Framework\TestCase;

use Hep\Foundation\Str;

/**
 */
class upperTest extends TestCase
{
    public function testLowerCase()
    {
        $this->assertEquals(upper('upper'), 'UPPER');
    }
}

