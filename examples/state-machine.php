<?php

require_once '../vendor/autoload.php';

use Hep\Foundation\StateMachine as Machine;

class ExampleMachine extends Machine
{
    protected $container;

    public function __construct($container, $initial)
    {
        $this->container = $container;

        $this->addState('first', new ExampleState($container, ['left', 'right']));
        $this->addState('left', new ExampleState($container, ['last']));
        $this->addState('right', new ExampleState($container, ['last']));
        $this->addState('last', new ExampleState($container));

        $this->currentState = $initial;

        // should this processEnter on the initial state?
        // probably not because if we are using an initial state somewhere
        // in the middle of the workflow, it may be weird
    }
}

class ExampleState extends \Hep\Foundation\StateMachine\State
{
    protected $container;

    public function __construct($container, $events = []) {
        $this->container = $container;

        if (!empty($events)) {
            $this->events = $events;
        }
    }

    public function processEnter($data = [])
    {
        $this->container->value = __NAMESPACE__.'\\'.__CLASS__.'::'.__FUNCTION__;
        echo $this->container->value, PHP_EOL;
    }

    public function processExit($data = [])
    {
        $this->container->value = __NAMESPACE__.'\\'.__CLASS__.'::'.__FUNCTION__;
        echo $this->container->value, PHP_EOL;
    }
}

// rando stdClass for a container whee
$machine = new ExampleMachine(new stdClass, 'first');

// print_r($machine);

$check = $machine->can('left');

// this will work
$ok = $machine->trigger('left', []);

// this will not work
$ok = $machine->trigger('right');

// this will work
$ok = $machine->trigger('last');
