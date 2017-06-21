<?php

namespace App\Models;


use App\Core\Mvc\Model;
use App\Core\Dbase\Db;

class Quest extends Model
{

    const TABLE = 'Quest3';
    const PK = 'id';

    public $id;
    public $name;
    public $parent;

    /**
     * Метод ищет количество записей по кол-ву родителей и потомков
     * @param $parent int
     * @param $child integer
     * @return array Массив объектов
     */
    public static function findByParentAndChild($parent, $child)
    {
        $db = Db::instance();
        $t1 = static::TABLE;
        return $res =
            $db->query(
                'SELECT t1.*, count(t2.id) AS count
                 FROM ' . $t1 . ' AS t1 INNER JOIN ' . $t1 . ' AS t2 ON ' . ' t1.id = t2.parent
                 WHERE t1.parent = :parent ' .
                'GROUP BY t1.id
                 HAVING count(t2.id) >= :child',
                static::class, [':parent' => $parent, ':child' => $child])
                ?: false;
    }
}
//SELECT
//  t1.*
//  , count(t2.id) AS count
//FROM
//  Quest3 AS t1
//INNER JOIN
//  Quest3 AS t2 on t1.id = t2.parent
//WHERE
//  t1.parent = 0
//GROUP BY
//  t1.id
//HAVING
//  count(t2.id) >= 3