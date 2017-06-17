<?php
namespace App\Core\Dbase;

use App\Config;
use App\Core\Dbase\DbException;
use App\Core\Mvc\TSinglton;

class Db
{

    /**
     * Синглтон отвечающий за создание не более одного объекта класса
     */
    use TSinglton;
    /**
     * @var \App\Config
     */
    protected $config;

    /**
     * @var \PDO
     */
    protected $dbh;

    /**
     * Метод-конструктор.
     * @throws \App\Core\Dbase\DbException
     */
    protected function __construct()
    {
        $config = Config::instance();
        try {
            $this->dbh = $this->getPdoObj($config);
        } catch (\PDOException $e) {
            throw new DbException('Не удалось подключиться к БД ' . '<br>' . $e->getMessage());
        }
    }

    /**
     * Метод подключается к БД и создаёт объект PDO
     * @param $config array Конфигурация БД
     * @return \PDO
     */
    protected function getPdoObj($config)
    {
        $driverhostname = $config->data['db']['driver'] . ':host=' . $config->data['db']['host'] . ';dbname=' .
            $config->data['db']['dbname'];
        $dbh = new \PDO($driverhostname, $config->data['db']['user'], $config->data['db']['password']);
        $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $dbh;
    }

    /**
     * Метод подготавливает запрос и запускает его на выполнение
     * @param $sql string Строка запроса
     * @param array $options Параметры запроса
     * @return bool
     */
    public function execute($sql, $options = [])
    {
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($options);
        return $res;
    }

    /**
     * Метод подготавливает запрос, запускает его на выполнение и
     * возвращает массив, содержащий все строки результирующего набора
     * @param $sql string Строка запроса
     * @param $class string Полное имя класса
     * @param array $options Параметры запроса
     * @return array
     * @throws \App\Core\Dbase\DbException
     */
    public function query($sql, $class, $options = [])
    {
        try {
            $sth = $this->dbh->prepare($sql);
            $res = $sth->execute($options);
            if (false !== $res) {
                return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
            }
        } catch (\PDOException $e) {
            throw new DbException('Запрос не выполнен. Ошибка.' . '<br>' . $e->getMessage());
        }
        return [];
    }

    protected function fetchFromDb ($sth)  {
        while  ($row = $sth->fetch())  {
            yield $row ;
        }
    }

    public function queryEach($sql, $class, $options = [])
    {
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->setFetchMode(\PDO::FETCH_CLASS, $class);
            $res = $sth->execute($options);
            if (false !== $res) {
                return $this->fetchFromDb($sth);
            }
        } catch (\PDOException $e) {
            throw new DbException('Запрос не выполнен. Ошибка.' . '<br>' . $e->getMessage());
        }
        return [];
    }

    /**
     * Метод возвращает id последней созданной записи в таблице БД
     * @return string
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}
