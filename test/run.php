<?php

include '../vendor/autoload.php';

use Hep\Foundation\Stache;

dump([1], new \stdClass);
dump(true, false, null);

assert(all(true, [1], 1) == true);
assert(any(false, [], 1) == true);

assert(all(false, [0], 0) == false);
assert(any(false, false && true) == false);

assert(_checked('yes', 'yes') == 'checked');
assert(_checked('yes', 'no') == '');



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

