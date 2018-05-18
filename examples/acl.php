<?php

require_once '../vendor/autoload.php';

$acl = new Hep\Foundation\ACL();

$acl->addRole('warriors');
$acl->addRole('wizards');
$acl->addRole('hobbits');
$acl->addRole('guests');

$acl->addRole('warriors.Aragorn');
$acl->addRole('warriors.Legolas');
$acl->addRole('warriors.Gimli');
$acl->addRole('wizards.Gandalf');
$acl->addRole('hobbits.Frodo');
$acl->addRole('hobbits.Bilbo');
$acl->addRole('hobbits.Merry');
$acl->addRole('hobbits.Pippin');
$acl->addRole('guests.Gollum');

$acl->allow('warriors', 'Weapons');
$acl->allow('warriors', 'Ale');
$acl->allow('warriors', 'Rations');
$acl->allow('warriors', 'Pork');
$acl->allow('warriors.Aragorn', 'Diplomacy');

$acl->deny('warriors.Gimli', 'Ale');

$acl->allow('wizards', 'Ale');
$acl->allow('wizards', 'Pork');
$acl->allow('wizards', 'Diplomacy');

$acl->allow('hobbits', 'Ale');
$acl->allow('hobbits.Frodo', 'Ring');
$acl->allow('hobbits.Pippin', 'Diplomacy');

$acl->deny('hobbits.Merry', 'Ale');

$acl->allow('visitors', 'Pork');

// Though the King may not want to let everyone
// have unfettered access
$acl->deny('warriors.Legolas', 'Weapons', 'delete');
$acl->deny('warriors.Gimli', 'Weapons', 'delete');

dump($acl);

$matrix = [
    'wizards.Gandalf' => ['Weapons' => false, 'Ring' => false, 'Pork' => true, 'Diplomacy' => true, 'Ale' => true],
    'warriors.Aragorn' => ['Weapons' => true, 'Ring' => false, 'Pork' => true, 'Diplomacy' => true, 'Ale' => true],
    'warriors.Legolas' => ['Weapons' => true, 'Ring' => false, 'Pork' => true, 'Diplomacy' => false, 'Ale' => true],
    'warriors.Gimli' => ['Weapons' => true, 'Ring' => false, 'Pork' => true, 'Diplomacy' => false, 'Ale' => false],
    'hobbits.Bilbo' => ['Weapons' => false, 'Ring' => false, 'Pork' => false, 'Diplomacy' => false, 'Ale' => true],
    'hobbits.Frodo' => ['Weapons' => false, 'Ring' => true, 'Pork' => false, 'Diplomacy' => false, 'Ale' => true],
    'hobbits.Pippin' => ['Weapons' => false, 'Ring' => false, 'Pork' => false, 'Diplomacy' => true, 'Ale' => true],
    'hobbits.Merry' => ['Weapons' => false, 'Ring' => false, 'Pork' => false, 'Diplomacy' => false, 'Ale' => false],
    'visitors.Gollum' => ['Weapons' => false, 'Ring' => false, 'Pork' => true, 'Diplomacy' => false, 'Ale' => false],
];

foreach ($matrix as $role => $resources) {
    foreach ($resources as $resource => $expect) {
        $expect = var_export($expect, true);
        $result = var_export($acl->isAllowed($role, $resource), true);

        $message = "expected isAllowed($role, $resource) to be $expect but got $result";

        assert(
            $result == $expect,
            new Exception($message)
        );
    }
}
