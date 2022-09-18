<?php

// get configuration
function config($path) {
    $keys = explode('.', $path);

    if (! file_exists($filename = ROOT . '/config/' . array_shift($keys) . '.php')) {
        return null;
    }

    $configs = require($filename);

    foreach ($keys as $key) {
        if (! isset($configs[$key])) {
            return null;
        }

        $configs = $configs[$key];
    }

    return $configs;
}

// random string
function randStr($len = 10) {
    $chars    = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charsLen = strlen($chars);
    
    $randStr = '';
    for ($i = 0; $i < $len; $i++) {
        $randStr .= $chars[rand(0, $charsLen-1)];
    }

    return $randStr;
}
