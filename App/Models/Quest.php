<?php

namespace App\Models;


use App\Core\Mvc\Model;

class Quest extends Model
{

    const TABLE = 'Quest3';
    const PK = 'id';

    public $id;
    public $name;
    public $parent;

}