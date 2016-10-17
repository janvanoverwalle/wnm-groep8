<?php

if (!function_exists('classAutoLoader')) {
    function classAutoLoader($className)
    {
        $fileName = __DIR__ . DIRECTORY_SEPARATOR .
            'src' . DIRECTORY_SEPARATOR .
            str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($fileName)) {
            require $fileName;
        }
    }
}
spl_autoload_register('classAutoLoader');
