<?php

namespace Hep\Foundation;

class ACL
{
    protected $resources = [];
    protected $roles = [];

    protected $cache = [];

    const ALLOW = true;
    const DENY = false;

    public function __construct($default = 'deny') {
        $this->$default('[root]', '*', '*');
    }

    public function allow($role, $resource, $actions = '*') {}
    public function deny($role, $resource, $actions = '*') {}

    public function isAllowed($role, $resource, $action) {}

}
