<?php


use PHPUnit\Framework\TestCase;

use Hep\Foundation\Stache;

/**
 */
class StacheTest extends TestCase
{
    protected $engine;

    public function setUp() {
        $this->engine = new Stache();
        $this->engine->allowTransforms(false);
    }

    public function testEmpty() {
        $this->assertEquals($this->engine->render('{ empty }', []), '{ empty }');
        $this->assertEmpty($this->engine->render('{ empty }', [], true));
    }

    public function testAllowTransforms() {
        $this->assertEquals($this->engine->allowTransforms(), false);
        $this->engine->allowTransforms(true);
        $this->assertEquals($this->engine->allowTransforms(), true);
    }

    public function testRender() {
        $this->assertEquals($this->engine->render('{ test }', ['test' => 'SUCCESS']), 'SUCCESS');

        $this->assertEquals($this->engine->render('{test | strtolower}', ['test' => 'SUCCESS']), 'SUCCESS');

        $this->engine->allowTransforms(true);

        $this->assertEquals($this->engine->render('{test | strtolower}', ['test' => 'SUCCESS']), 'success');

        $this->assertEquals($this->engine->render('{ item.link }', [
            'item' => [
                'link' => 'success'
            ]
        ]), 'success');

        $this->engine->allowTransforms(false);
    }

    public function testForbiddenFunctions() {
        $this->engine->allowTransforms(true);

        $this->assertEquals($this->engine->render('{test | exec | upper | passthru | shell_exec | system }', ['test' => 'success']), 'SUCCESS');

        $this->engine->allowTransforms(false);
    }
}

