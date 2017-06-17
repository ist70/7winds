<?php

namespace App\Models;

use App\Core\Mvc\Model;

class Author extends Model
{

    /**
     * Это модель класса для таблицы "Authors" .
     * @property integer $id_author
     * @property string $firstname
     * @property string $lastname
     * @property string $email
     */
    const TABLE = 'authors';
    const PK = 'id_author';
    public $id_author;
    public $firstname;
    public $lastname;
    public $email;

}
