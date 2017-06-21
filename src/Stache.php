<?php

namespace Hep\Foundation;

// it's like mustache... but smaller
class Stache {

    // transforms must have a single input and produce a single output
    // if you need something with more inputs, use currying
    protected $allowTransforms = true;
    protected $forbiddenFunctions = [
        'exec',
        'passthru',
        'shell_exec',
        'system'
    ];

    public function __construct() {}

    public function allowTransforms($value = null) {
        if(is_bool($value)) {
            $this->allowTransforms = $value;
        }

        return $this->allowTransforms;
    }

    // context should allow for multilevel arrays: { parent.child }
    public function render($template, $context, $replaceEmpty = false) {
        $context = array_dot($context);

        preg_match_all('/\{.*\}/sU', $template, $matches);
        $chunks = array_unique($matches[0]);

        foreach($chunks as $original) {
            $chunk = substr($original, 1, -1);
            $transforms = array_map('trim', explode('|', $chunk));
            $key = array_shift($transforms);

            if(array_key_exists($key, $context)) {
                $value = $context[$key];

                if($this->allowTransforms) {
                    foreach($transforms as $transform) {
                        if(in_array($transform, $this->forbiddenFunctions)) {
                            continue;
                        }

                        if(is_string($value)) {
                            $value = $transform($value);
                        }
                    }
                }

                $template = str_replace($original, $value, $template);
            }
            elseif($replaceEmpty) {
                $template = str_replace($original, '', $template);
            }
        }

        return $template;
    }
}
