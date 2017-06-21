<?php

use Hep\Foundation\Stache;

include('../vendor/autoload.php');

$engine = new Stache();
// $engine->allowTransforms(false);

echo $engine->render('{ item.link }', [
    'item' => [
        'value' => 1,
        'link' => 'asdf'
    ]
]);
echo $engine->render('{ test }{test | strtolower}', ['test' => 'SUCCESS']);
