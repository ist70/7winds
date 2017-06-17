<?php

namespace App\Core;

class AdminDataTable
{

    public $rows;
    public $funcs;
    public $data = [];
    public $namefunc = [];

    public function __construct($rows, $funcs)
    {
        $this->rows = $rows;
        $this->funcs = $funcs;
    }

    public function render1()
    {
        foreach ($this->funcs as $key => $func) {
            foreach ($this->rows as $row) {
                $this->data[$row][$key] = $func($row);
            }
            $this->namefunc[] = $key;
        }
    }

    public function render()
    {
        foreach ($this->rows as $row) {
            $item = [];
            foreach ($this->funcs as $func) {
                $item[] = $func($row);
            }
            $this->data[] = $item;
        }
        return $this->data;
    }

}