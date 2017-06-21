<?php

include '../vendor/autoload.php';

use Hep\Foundation\Stache;

$engine = new Stache();

assert($engine->render('{ empty }', []) === '{ empty }');
assert($engine->render('{ empty }', [], true) === '');

assert($engine->render('{ test }', ['test' => 'SUCCESS']) === 'SUCCESS');
assert($engine->render('{test | exec | passthru | shell_exec | system }', ['test' => 'SUCCESS']) === 'SUCCESS');
assert($engine->render('{test | strtolower}', ['test' => 'SUCCESS']) === 'success');

assert($engine->render('{ item.link }', [
    'item' => [
        'link' => 'success'
    ]
]) === 'success');

$engine->allowTransforms(false);
assert($engine->render('{test | strtolower}', ['test' => 'SUCCESS']) === 'SUCCESS');

