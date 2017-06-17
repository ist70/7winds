<?php

namespace App\Core\Mvc;

use App\Core\Dbase\Db;
use App\Core\MultiException;
use App\Core\Mvc\Rules;

abstract class Model implements \Countable
{

    const TABLE = '';
    const PK = '';

    /**
     * Метод проверяет, новая запись или нет
     * @return bool
     */
    public function isNew()
    {
        return empty($this->{static::PK});
    }

    /**
     * Метод возвращает имя PK модели
     * @return string
     */
    public function getPk()
    {
        return $this->{static::PK};
    }

    /**
     * Метод проверяет соответствие значений свойств объекта
     *правилам
     * @throws MultiException
     * @throws array
     */
    public function validate()
    {
        $e = new MultiException();
        $rules = Rules::filters();
        foreach ($this->conditions() as $condition) {
            foreach ($condition[1] as $filter) {
                $fun = $rules[$filter];
                if (false == $fun($this->{$condition[0]})) {
                    $e[] = new \Exception('Ошибка валидации свойства: ' . $condition[0] . ';  фильтр: ' . $filter);
                };
            }
        }
        if (!empty($e[0])) {
            throw $e;
            return false;
        }
        return true;
    }

    /**
     * Метод заполняет данными свойства модели
     * @param $post array
     */
    public function fill(array $data)
    {
        $keys = array_keys($data);
        foreach ($keys as $attribute) {
            if (static::PK == $attribute) {
                continue;
            }
            $this->{$attribute} = $data[$attribute];
        }
        return $this;
    }

    /**
     * Метод ищет все записи модели
     * @return array массив объектов
     */
    public static function findAll()
    {
        $db = Db::instance();
        return $db->query(
            'SELECT * FROM ' . static::TABLE,
            static::class
        );
    }

    /**
     * Метод ищет все записи модели
     * @return array массив объектов
     */
    public static function findEach($lim)
    {
        $db = Db::instance();
        return $db->queryEach(
            'SELECT * FROM ' . static::TABLE,
            static::class
        );
    }

    /**
     * Метод ищет одну запись модели по её PK
     * @param $id string PK модели
     * @return object один объект
     */
    public static function findById($id)
    {
        $db = Db::instance();
        return $res =
            $db->query(
                'SELECT * FROM ' . static::TABLE . ' WHERE ' . static::PK . ' = :id',
                static::class, [':id' => $id])[0]
                ?: false;
    }

    /**
     * Метод ищет заданное колличество последних записей у Модели
     * @param $limit integer Колличество записей
     * @return array Массив объектов
     */
    public static function findLastRecords($limit)
    {
        $db = Db::instance();
        return $res = $db->query(
            sprintf('SELECT * FROM ' . static::TABLE . ' ORDER BY ' . static::PK . ' DESC  LIMIT %u', $limit),
            static::class) ?: false;
    }

    /**
     * Метод решает, что делать с объектом:
     * сохранять в БД, если он новый или изменить существующий
     */
    public function save()
    {
        if ($this->isNew()) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * Метод сохраняет новый объект в БД
     */
    public function insert()
    {
        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if (static::PK == $k || 'data' == $k) {
                continue;
            }
            $columns[] = $k;
            $values[':' . $k] = $v;
        }
        $sql = 'INSERT INTO ' . static::TABLE . '(' . implode(',', $columns) . ')
                VALUES(' . implode(',', array_keys($values)) . ')
        ';
        $db = Db::instance();
        $db->execute($sql, $values);
        $this->{static::PK} = $db->lastInsertId();
    }

    /**
     * Метод производит изменения в существующем объекте и сохраняет его в БД
     */
    public function update()
    {
        $columns = [];
        $values = [];
        foreach ($this as $k => $v) {
            if (static::PK == $k || 'data' == $k) {
                continue;
            }
            $columns[] = $k . '=:' . $k;
            $values[':' . $k] = $v;
        }
        $sql = 'UPDATE ' . static::TABLE .
            ' SET ' . implode(', ', $columns) .
            ' WHERE ' . static::PK . ' = ' . $this->getPk();
        $db = Db::instance();
        $db->execute($sql, $values);
    }

    /**
     * Метод удаляет объект из БД
     * @return bool Возвращает True, если объект удалён и False, если такого объекта нет в БД
     */
    public function delete()
    {
        if ($this->isNew()) {
            return false;
        }
        $sql = 'DELETE FROM ' . static::TABLE .
            ' WHERE ' . static::PK . ' = ' . $this->getPk();
        $db = Db::instance();
        $db->execute($sql);
        return true;
    }

    /**
     * Метод реализующий интерфейс Countable
     * @return integer Колличество элементов
     */
    public function count()
    {
        return count($this->data);
    }

}
