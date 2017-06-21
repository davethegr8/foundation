<?php

include '../vendor/autoload.php';

use Hep\Foundation\Stache;

// dump([1], new \stdClass);
// dump(true, false, null);

dump(_checked('yes', 'yes'));
var_dump(_checked('yes', 'no'));

$engine = new Stache();

assert($engine->render('{ empty }', []) === '{ empty }');
assert($engine->render('{ empty }', [], true) === '');

assert($engine->render('{ test }', ['test' => 'SUCCESS']) === 'SUCCESS');
assert($engine->render('{test | exec | upper | passthru | shell_exec | system }', ['test' => 'success']) === 'SUCCESS');
assert($engine->render('{test | strtolower}', ['test' => 'SUCCESS']) === 'success');

assert($engine->render('{ item.link }', [
    'item' => [
        'link' => 'success'
    ]
]) === 'success');

$engine->allowTransforms(false);
assert($engine->render('{test | strtolower}', ['test' => 'SUCCESS']) === 'SUCCESS');

