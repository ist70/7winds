<?php

namespace App\Core\Mvc;

trait TMagic
{

    protected $data = [];

    /**
     * Магический метод set
     * @param $k
     * @param $v
     */
    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    /**
     * Магический метод get
     * @param $k
     * @return mixed
     */
    public function __get($k)
    {
        return $this->data[$k];
    }

    /**
     * Магический метод isset
     * @param $k
     * @return bool
     */
    public function __isset($k)
    {
        return isset($this->data[$k]);
    }

}
