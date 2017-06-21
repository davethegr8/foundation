<?php

use PHPUnit\Framework\TestCase;

/**
 */
final class checkedTest extends TestCase
{

    public function testValuesMatch()
    {
    //     $this->assertEquals(
    //         'checked',
    //         'checked'
    //     );
    }

    public function testValuesDontMatch()
    {
        $this->assertEmpty(
            _checked('yes', 'no')
        );
    }

    public function testNullCheckValue()
    {
        $this->assertEquals(
            _checked('yes'),
            'checked'
        );
    }
}

