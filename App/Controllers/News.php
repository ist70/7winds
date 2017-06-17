<?php

namespace App\Controllers;

use App\Core\Mvc\Controller;
use App\Core\Mvc\Exception404;
use App\Models\News as NewsModel;

class News extends Controller
{

    /**
     * Метод вывода всех новостей
     *
     */
    protected function actionAll()
    {
        $news = NewsModel::findAll();
        $this->view->render('/news/index.html', [
            'news' => $news,
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    protected function actionEach($lim)
    {
        $news = NewsModel::findEach($lim);
        $this->view->render('/news/index.html', [
            'news' => $news,
            'resource' => \PHP_Timer::resourceUsage()
        ]);
    }

    /**
     * Метод вывода одной новости по её id
     *
     */
    protected function actionOne()
    {
        $id = (int)$_GET['id'] ?: false;
        if (empty($id)) {
            $this->redirect('/');
        }
        if (!empty($article = NewsModel::findById($id))) {
            $this->view->render('/news/one.html', [
                'article' => $article,
                'resource' => \PHP_Timer::resourceUsage()
            ]);
        } else {
            $this->view->erroradmin = false;
            throw new Exception404('Страница с такой новостью не найдена');
        }
    }

}
