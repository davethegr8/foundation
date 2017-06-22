<?php

use PHPUnit\Framework\TestCase;

/**
 */
class checkedTest extends TestCase
{
    public function testValuesMatch()
    {
        $this->assertEquals(
            checked('yes', 'yes'),
            'checked'
        );
    }

    public function testValuesDontMatch()
    {
        $this->assertEmpty(
            checked('yes', 'no')
        );
    }

    public function testNullCheckValue()
    {
        $this->assertEquals(
            checked('yes'),
            'checked'
        );
    }

    public function testActive()
    {
        $this->assertEquals(
            active('yes', 'yes'),
            'active'
        );

        $this->assertEmpty(
            active('yes', 'no'),
            ''
        );
    }

    public function testSelected()
    {
        $this->assertEquals(
            selected('yes', 'yes'),
            'selected'
        );

        $this->assertEmpty(
            selected('yes', 'no'),
            ''
        );
    }
}

