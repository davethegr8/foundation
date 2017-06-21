<?php

use PHPUnit\Framework\TestCase;

/**
 */
final class checkedTest extends TestCase
{

    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testValuesMatch()
    {
    //     $this->assertEquals(
    //         'checked',
    //         'checked'
    //     );
    }

    public function testValuesDoNotMatch()
    {
        $this->assertEmpty(
            _checked('yes', 'no')
        );
    }
}

