<?php

// based on https://book.cakephp.org/2.0/en/core-libraries/components/access-control-lists.html

namespace Hep\Foundation;

class ACL
{

    protected $roles = [];

    protected $cache = [];

    protected $tree = [];

    const ALLOW = true;
    const DENY = false;

    public function __construct($default = 'deny')
    {
        $this->addRole('');

        $this->$default('', '*', '*');
    }

    public function allow($role, $resource, $actions = '*')
    {
        $role = '.'.$role;

        if (!is_array($this->tree[$role])) {
            $this->tree[$role] = [];
        }

        if (!is_array($this->tree[$role][$resource])) {
            $this->tree[$role][$resource] = [];
        }

        $this->tree[$role][$resource] = array_merge(
            $this->tree[$role][$resource],
            [$actions => static::ALLOW]
        );
    }

    // todo handle actions
    public function deny($role, $resource, $actions = '*')
    {
        $role = '.'.$role;

        if (!is_array($this->tree[$role])) {
            $this->tree[$role] = [];
        }

        if (!is_array($this->tree[$role][$resource])) {
            $this->tree[$role][$resource] = [];
        }

        $this->tree[$role][$resource] = array_merge(
            $this->tree[$role][$resource],
            [$actions => static::DENY]
        );
    }

    public function isAllowed($role, $resource, $action = '*')
    {
        $role = '.'.$role;

        // dump($role.' '.$resource.' '.$action);
        $allow = null;

        $parts = explode('.', $role);
        // dump($parts);

        $fqr = '.';
        foreach ($parts as $index => $part) {
            if ($index > 0) {
                $fqr = implode('.', array_slice($parts, 0, $index+1));
            }

            // dump('fqr '.$fqr);

            if (isset($this->tree[$fqr]['*']['*'])) {
                // dump('*.*');
                $allow = $this->tree[$fqr]['*']['*'];
            }

            if (isset($this->tree[$fqr][$resource]['*'])) {
                // dump($resource.'.*');
                $allow = $this->tree[$fqr][$resource]['*'];
            }

            // dump('isset:', isset($this->tree[$fqr][$resource][$action]));
            if (isset($this->tree[$fqr][$resource][$action])) {
                // dump($resource.'.'.$action);
                $allow = $this->tree[$fqr][$resource][$action];
            }

            // dump($fqr.' allow '.var_export($allow, true));
        }

        return $allow;
    }

    // todo fix this weird . thing
    // todo do I need roles?
    public function addRole($name, $parent = '')
    {
        if ($parent == '') {
            $parent = '.';
        }

        if ($name != '.') {
            $name = $parent.'.'.$name;
        }

        $path = explode('.', $name);
        $parent_part = null;

        foreach ($path as $part) {
            if (!array_key_exists($part, $this->roles)) {
                $this->roles[$part] = [];
            }

            if (!empty($parent_part) && !in_array($part, $this->roles[$parent_part])) {
                $this->roles[$parent_part][] = $part;
            }

            $parent_part = $part;
        }
    }


}
