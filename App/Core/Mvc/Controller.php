<?php

namespace App\Core\Mvc;

abstract class Controller
{

    /**
     * Контроллер новостей
     *
     * @var View Объект класса App/View
     */
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Метод для администрирование запуска экшенов этого класса
     *
     * @param $action string Название экшена
     * @return string
     */
    public function action($action, $params = '')
    {
        $methodName = 'action' . $action;
        return $this->$methodName($params);
    }

    /**
     * Метод перехода по указанному адресу
     *
     * @param $url
     * @param int $code
     */
    public function redirect($url, $code = 301)
    {
        header("location: " . $url, true, $code);
        exit;
    }

}
