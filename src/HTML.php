<?php

namespace Hep\Foundation;

class HTML {

    function getAttrs($tag) {
        // todo handle ' quotes
        // todo handle no quotes
        // todo handle no values
        preg_match_all('/(\w+)=\"(.+)\"/U', $tag, $matches);
        return array_combine($matches[1], $matches[2]);
    }

    function checked($value, $check = null, $return = 'checked') {
        return any(
            ($check !== null && $value == $check),
            ($value && $check === null)
        ) ? $return : '';
    }

    function active($value, $check = null)  {
        return _checked($value, $check, 'active');
    }

    function selected($value, $check = null) {
        return _checked($value, $check, 'selected');
    }

}
