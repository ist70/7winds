<?php

namespace App\Models;

use App\Core\MultiException;
use App\Core\Mvc\Model;

class News extends Model
{

    /**
     * Это модель класса для таблицы "Orders" .
     * @property integer $id_news
     * @property string $title
     * @property string $description
     * @property string $published
     * @property integer $status
     * @property integer $author_id
     */

    const TABLE = 'news';
    const PK = 'id_news';
    const ACTIV_PUBLISHED = 1;
    const PASSIVE_PUBLISHED = 0;

    public $id_news;
    public $title;
    public $description;
    public $published;
    public $status;
    public $author_id;
    protected $data = [];

    /**
     * Метод, в котором перечислены свойства класса и
     * условия при их сохранении
     * @return array
     */
    public function conditions()
    {
        return [
            ['title', ['required', 'trim']],
            ['description', ['required', 'trim']],
            ['published', ['required']],
            ['status', ['required']],
        ];
    }

    /**
     * Это магический метод __set
     * @param $k string Имя свойства
     * @param $v mixed Значение свойства
     */
    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    /**
     * Это магический метод __get, доработанный под данную модель. При запросе
     * свойства author проверяет, не пустое ли у объекта свойство $author_id, и
     * если не пустое, то возвращает объект класса Author
     * @param $k string Имя свойства
     * @return null  Если имя свойства не равно 'author'
     * @return object Authors, если имя свойства равно author
     */
    public function __get($k)
    {
        switch ($k) {
            case 'author':
                return Author::findById($this->author_id);
                break;
            default:
                return null;
                break;
        }
    }

    /**
     * Это магический метод проверяет свойство методом 'isset()'
     * @param $k string Имя свойства
     * @return bool
     */
    public function __isset($k)
    {
        switch ($k) {
            case 'author':
                return !empty($this->author_id);
                break;
            default:
                return false;
        }
    }

    /**
     * Метод присвивает пришедшие данные свойствам объекта
     * @param $post array
     * @return $this  Возвращаем обект
     */
    public function fill(array $post)
    {
        parent::fill($post);
        $this->published = date("Y-m-d H:i:s");
        $this->status = self::ACTIV_PUBLISHED;
        $this->author_id = 1;
        $this->validate();
        return $this;
    }

}
