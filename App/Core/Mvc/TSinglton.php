<?php

namespace App\Core\Mvc;

trait TSinglton
{

    protected static $instance;

    public static function instance()
    {
        if (null === static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }

}
