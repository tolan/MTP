<?php

namespace MTP;

class Autoloader {

    public static function register() {
        spl_autoload_register(array(__CLASS__, 'autoloader'));
    }

    protected static function autoloader($class) {
        $path   = __DIR__.ltrim(str_replace('\\', '/', $class), __NAMESPACE__).'.php';
        $loaded = false;

        if (file_exists($path)) {
            include_once $path;
            $loaded = true;
        }

        return $loaded;
    }
}
