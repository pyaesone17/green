<?php

if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (! function_exists('app')) {
    function app($service)
    {
        return \Green\App::getInstance()->get($service);
    }
}

if (! function_exists('logging')) {
    function logging($level, $message,...$extra)
    {
        return app('log')->writeLog($level, $message,$extra);
    }
}