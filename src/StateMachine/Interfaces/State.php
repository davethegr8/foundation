<?php

namespace Hep\Foundation\StateMachine\Interfaces;

interface State
{
    public function getEvents();
    public function processEnter($data = []);
    public function processExit($data = []);
}
