<?php

namespace App\Core\Mvc;

class View implements \Countable
{

    use TMagic;

    private $twig;

    /**
     * Метод создаёт объекты для шаблонизатора Twig
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates');
            $this->twig = new \Twig_Environment($loader);
        } catch (\Twig_Error $e) {
            throw new \Exception('Не удалось подключить шаблон ' . '<br>' . $e->getMessage());
        }
    }

    /**
     * Метод выводит на экран шаблон страницы
     * @param $template string Путь к шаблону
     * @param $data array Данные для шаблона
     */
    public function render($template, $data = [])
    {
        echo $this->twig->loadTemplate($template)->render($data);
    }

    /**
     * Count elements of an object
     * @return int The custom count as an integer.
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->data);
    }

}
