<?php

namespace Hep\Foundation\StateMachine;

class State implements Interfaces\State
{
    protected $name = '';
    protected $events = [];

    public function __construct($events = [])
    {
        if (!empty($events)) {
            $this->events = $events;
        }
    }

    public function getEvents() {
        return $this->events;
    }

    public function processEnter($data = []) {}
    public function processExit($data = []) {}
}
