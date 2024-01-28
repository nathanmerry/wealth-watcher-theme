<?php

function array_find(array $array, callable $callback)
{
    foreach ($array as $key => $value) {
        if ($callback($value, $key, $array)) {
            return $value;
        }
    }

    return null;
}
