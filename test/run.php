<?php

include '../vendor/autoload.php';

use Hep\Foundation\Stache;

$engine = new Stache();
// $engine->allowTransforms(false);

echo $engine->render('{ item.link }', [
    'item' => [
        'value' => 1,
        'link' => 'asdf'
    ]
]);
echo $engine->render('{ test }{test | strtolower}', ['test' => 'SUCCESS']);
