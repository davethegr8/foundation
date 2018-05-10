<?php

namespace Hep\Foundation\StateMachine\Interfaces;

use Hep\Foundation\StateMachine\Interfaces\State;

interface Machine
{
    public function current();
    public function states();
    public function trigger($state, $data = []);
    public function can($next);
    public function addState($name, State $state);
}
