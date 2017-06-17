<?php

namespace App\Core;

trait TCollection
{

    protected $data = [];

    /**
     * Метод реализующий интерфейс ArrayAccess
     * @param string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data[$key]);
    }

    /**
     * Метод реализующий интерфейс ArrayAccess
     * @param string $key
     * @return array или NULL
     */
    public function offsetGet($key)
    {
        return $this->offsetExists($key) ? $this->data[$key] : null;
    }

    /**
     * Метод реализующий интерфейс ArrayAccess
     * @param string $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    /**
     * Метод реализующий интерфейс ArrayAccess
     * @param string $key
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Метод реализующий интерфейс Iterator
     * возвращает метку в начало массива
     */
    public function rewind()
    {
        reset($this->data);
    }

    /**
     * Метод реализующий интерфейс Iterator
     * возвращает текущее значение массива
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * Метод реализующий интерфейс Iterator
     * возвращает ключ массива
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Метод реализующий интерфейс Iterator
     * возвращает следующий элемент массива
     */
    public function next()
    {
        return next($this->data);
    }

    /**
     * Метод реализующий интерфейс Iterator
     * проверяет валидность текущего элемента
     */
    public function valid()
    {
        return !false == current($this->data);
    }

}
