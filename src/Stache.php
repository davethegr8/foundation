<?php

namespace Hep\Foundation;

// it's like mustache... but smaller
class Stache {

    // filters must have a single input and produce a single output
    // if you need something with more inputs, use currying
    protected $allowFilters = true;
    protected $forbiddenFunctions = ['exec', 'passthru', 'shell_exec', 'system'];

    public function __construct() {}

    public function allowFilters($value = null) {
        if(is_bool($value)) {
            $this->allowFilters = $value;
        }

        return $this->allowFilters;
    }

    // context should allow for multilevel arrays: { parent.child }
    public function render($template, $context, $replaceEmpty = false) {}

}
