<?php

namespace Hep\Foundation;

use Hep\Foundation\StateMachine\Interfaces\State;

class StateMachine implements StateMachine\Interfaces\Machine
{
    protected $currentState;
    protected $states;

    public function __construct($initial, $states = [])
    {
        if (!empty($states)) {
            $this->states = $states;
        }

        $this->currentState = $initial;
    }

    public function current()
    {
        return $this->currentState;
    }

    public function states()
    {
        return $this->states;
    }

    public function addState($name, State $state)
    {
        $this->states[$name] = $state;
    }

    public function can($next)
    {
        echo "checking if machine can `$next`: ";
        $state = $this->states[$this->currentState];
        $ok = in_array($next, $state->getEvents());
        echo var_export($ok, true), PHP_EOL;
        return $ok;
    }

    public function trigger($next, $data = [])
    {
        echo "triggering state `$next`", PHP_EOL;
        if (!$this->can($next)) {
            echo "transition to `$next` not allowed", PHP_EOL;
            return false;
        }

        $state = $this->states[$this->currentState];
        echo "leaving state `{$this->currentState}`", PHP_EOL;

        // processExit return values are ignored. because reasons. (there's no
        // good way to handle them)
        $state->processExit($data);

        $this->currentState = $next;
        $state = $this->states[$this->currentState];
        echo "entering state `{$this->currentState}`", PHP_EOL;

        // processEnter doesn't _have_ to return a value, but if it does
        // it will be passed back to the calling code.
        $state->processEnter($data);

        // yeah I know this is janky
        return true;
    }
}
