<?php

if (!function_exists('__')) {
    function __($key, $replace = [])
    {
        return trans('messages.'.$key, $replace);
    }
}
