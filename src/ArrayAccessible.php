<?php

namespace Hep\Foundation;

trait ArrayAccessible {
    protected $arrayData = [];

    public function getData()
    {
        return $this->arrayData;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->arrayData[] = $value;
        } else {
            $this->arrayData[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->arrayData[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->arrayData[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->arrayData[$offset]) ? $this->arrayData[$offset] : null;
    }
}
