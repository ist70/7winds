<?php

/**
 * App\Models\News => ./App/Models/News.php
 */
function autoload($class)
{
    $classParts = explode('\\', $class);
    array_unshift($classParts, __DIR__);
    $path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}
require __DIR__ . '/vendor/autoload.php';
spl_autoload_register('autoload');
