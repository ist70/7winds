<?php

namespace App\Models;

use App\Core\Mvc\Model;

class User extends Model
{

    const TABLE = 'users';
    const PK = 'id_user';
    public $id_user;
    public $email;
    public $firstname;
    public $lastname;
    public $birthday;

}
